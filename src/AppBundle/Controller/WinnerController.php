<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\EntityManager;

/**
 * Winner controller as a Service.
 *
 */
class WinnerController extends Controller
{
  protected $em;

  public function __construct($em)
  {
    $this->em = $em;
  }

  /**
   * Generates a winner for a Lottery.
   *
   */
  public function generateWinnersAction()
  {
    $em = $this->em;

    $lotteryRepo = $em->getRepository('AppBundle:Lottery');
    $endedLotteries = $lotteryRepo->findEndedLotteries();

    foreach ($endedLotteries as $key => $lottery) {
        echo (sprintf("About to generate a winner for %s.",$lottery->getName()));
        // Get participants
        $participants = $lottery->getParticipants();

        if($participants->count() > 0 && !$lottery->getEnded()) {
          $winnerIndex = mt_rand(0, $participants->count() - 1);
          $winner = $participants->get($winnerIndex);
          $lottery->setWinner($winner);
          $lottery->setEnded(true);
          $em->persist($lottery);
          $em->flush();
          echo (sprintf("Selected participant: %s as the winner for %s.", $winner, $lottery->getName()));
        }
      else {
        echo (sprintf("Could not end the lottery %s.",$lottery->getName()));
      }
    }
    return new Response('DONE');
  }

}
