<?php

namespace AppBundle\Repository;

/**
 * LotteryRepository
 *
 */
class LotteryRepository extends \Doctrine\ORM\EntityRepository
{

  public function findEndedLotteries()
  {
    return $this->getEntityManager()
      ->createQuery('SELECT lot FROM AppBundle:Lottery lot WHERE lot.endDate < CURRENT_DATE() AND lot.ended = 0 ')
      ->getResult();

  }

}
