<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * Lottery
 *
 * @ORM\Table(name="lottery")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LotteryRepository")
 */
class Lottery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var int
     *
     * @ORM\Column(name="prize", type="integer")
     */
    private $prize;

    /**
     * @var bool
     *
     * @ORM\Column(name="ended", type="boolean")
     */
    private $ended;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="winner", referencedColumnName="id")
     */
    private $winner;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="participants",
     *      joinColumns={@ORM\JoinColumn(name="lottery_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $participants;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Lottery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Lottery
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Lottery
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set prize
     *
     * @param integer $prize
     *
     * @return Lottery
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }

    /**
     * Get prize
     *
     * @return int
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * Set ended
     *
     * @param boolean $ended
     *
     * @return Lottery
     */
    public function setEnded($ended)
    {
        $this->ended = $ended;

        return $this;
    }

    /**
     * Get ended
     *
     * @return bool
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set Winner
     *
     * @param User $winner
     *
     * @return Lottery
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get Winner
     *
     * @return User
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add participant
     *
     * @param \AppBundle\Entity\User $participant
     *
     * @return Lottery
     */
    public function addParticipant(\AppBundle\Entity\User $participant)
    {
        $this->participants[] = $participant;
        return $this;
    }

    /**
     * Remove participant
     *
     * @param \AppBundle\Entity\User $participant
     */
    public function removeParticipant(\AppBundle\Entity\User $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Get participant by user ID
     *
     * @param integer $userId
     *
     * @return \AppBundle\Entity\User $participant
     */
    public function getParticipantByUserId($userId)
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('id', $userId));
        $participant = $this->participants->matching($criteria);
        
        return sizeof($participant) == 0 ? false : $participant;
    }
}
