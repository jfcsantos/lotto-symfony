<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Lottery;
use AppBundle\Form\LotteryType;

/**
 * Lottery controller.
 *
 * @Route("/lottery")
 */
class LotteryController extends Controller
{
    /**
     * Lists all Lottery entities.
     *
     * @Route("/", name="lottery_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $lotteryRepo = $em->getRepository('AppBundle:Lottery');
        $ongoingLotteries = $lotteryRepo->findByEnded(false);
        $closedLotteries = $lotteryRepo->findByEnded(true);

        return $this->render('lottery/lottery_list.html.twig', array(
            'ongoing_lotteries' => $ongoingLotteries,
            'closed_lotteries' => $closedLotteries,
        ));
    }

    /**
     * Creates a new Lottery entity.
     *
     * @Route("/new", name="lottery_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $lottery = new Lottery();
        $form = $this->createForm('AppBundle\Form\LotteryType', $lottery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lottery);
            $em->flush();

            return $this->redirectToRoute('lottery_show', array('id' => $lottery->getId()));
        }

        return $this->render('lottery/new.html.twig', array(
            'lottery' => $lottery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lottery entity.
     *
     * @Route("/{id}", name="lottery_show")
     * @Method("GET")
     */
    public function showAction(Lottery $lottery)
    {
//        $deleteForm = $this->createDeleteForm($lottery);
//      template_data['isParticipant'] = Participant.objects.get(user=request.user, lottery=template_data['lottery'])

//        $em = $this->getDoctrine()->getManager();
//
//        $lotteryRepo = $em->getRepository('AppBundle:Lottery');
        $isParticipant = false;
      
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
          $user = $this->get('security.token_storage')->getToken()->getUser();
          // authenticated REMEMBERED, FULLY will imply REMEMBERED (NON anonymous)
          $isParticipant = $lottery->getParticipantByUserId($user->getId());
        }

        return $this->render('lottery/view.html.twig', array(
            'lottery' => $lottery,
            'isParticipant' => $isParticipant,
//            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Adds a participant to a lottery.
     *
     * @Route("/{id}/participant/add", name="participant_add")
     * @Method("POST")
     */
    public function participantAddAction(Lottery $lottery, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if(isset($user)) {
          $isParticipant = $lottery->getParticipantByUserId($user->getId());
          if(!$isParticipant) {
            $lottery->addParticipant($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($lottery);
            $em->flush();
          }
         
        }
      return $this->redirectToRoute('fos_user_profile_show', array('id' => $lottery->getId()));
    }


    /**
     * Generates a winner for a Lottery.
     *
     * @Route("/{id}/winner/generate", name="generate_winner")
     * @Method("POST")
     */
    public function generateWinnerAction(Lottery $lottery, Request $request)
    {

      $securityContext = $this->container->get('security.authorization_checker');
      if ($securityContext->isGranted('ROLE_ADMIN')) {

      // Get participants
      $participants = $lottery->getParticipants();
      var_dump($participants);
//        if len(participants) > 0 and self.ended is False:
//            self.winner = random.choice(participants).user
//            self.ended = True
//            self.save()
//            return self.winner
//        else:
//            return False


      }

      if(isset($user)) {
        $isParticipant = $lottery->getParticipantByUserId($user->getId());
        if(!$isParticipant) {
          $lottery->addParticipant($user);
          $em = $this->getDoctrine()->getManager();
          $em->persist($lottery);
          $em->flush();
        }

      }
      return $this->redirectToRoute('fos_user_profile_show', array('id' => $lottery->getId()));
    }


  /**
     * Displays a form to edit an existing Lottery entity.
     *
     * @Route("/{id}/edit", name="lottery_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Lottery $lottery)
    {
        $deleteForm = $this->createDeleteForm($lottery);
        $editForm = $this->createForm('AppBundle\Form\LotteryType', $lottery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lottery);
            $em->flush();

            return $this->redirectToRoute('lottery_edit', array('id' => $lottery->getId()));
        }

        return $this->render('lottery/edit.html.twig', array(
            'lottery' => $lottery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lottery entity.
     *
     * @Route("/{id}", name="lottery_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Lottery $lottery)
    {
        $form = $this->createDeleteForm($lottery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lottery);
            $em->flush();
        }

        return $this->redirectToRoute('lottery_index');
    }

    /**
     * Creates a form to delete a Lottery entity.
     *
     * @param Lottery $lottery The Lottery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Lottery $lottery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lottery_delete', array('id' => $lottery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
