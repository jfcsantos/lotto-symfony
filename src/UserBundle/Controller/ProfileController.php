<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * Controller managing the user profile
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends BaseController
{
    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $lotteryRepo = $em->getRepository('AppBundle:Lottery');
        $ongoingLotteries = $lotteryRepo->findAll();
        $myPrizes = $lotteryRepo->findByWinner($user);
        $endedLotteries = [];
        foreach ($ongoingLotteries as $key => $lottery) {
            if(!$lottery->getParticipantByUserId($user->getId())) {
               unset($ongoingLotteries[$key]);
            }
            else {
              if($lottery->getEnded()) {
                $endedLotteries[] = $lottery;
                unset($ongoingLotteries[$key]);
              }
            }
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'ongoing_lotteries' => $ongoingLotteries,
            'past_lotteries' => $endedLotteries,
            'my_prizes' => $myPrizes,
        ));
    }

}
