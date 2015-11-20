<?php

namespace AppBundle\Entity;

use AppBundle\Services\Competitions\CompetitionManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="competition_session")
 */
class CompetitionSession
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Competition", inversedBy="sessions")
     */
    protected $competition;

    /**
     * The planned start time
     *
     * @ORM\Column(type="datetime")
     */
    protected $startTime;

    /**
     * Number of bosses available
     *
     * @ORM\Column(type="integer")
     */
    protected $bossCount;
    /**
     * Number of targets per boss
     *
     * @ORM\Column(type="integer")
     */
    protected $targetCount;
    /**
     * Number of details
     * e.g. 2 details = AB shoot, then CD
     *
     * @ORM\Column(type="integer")
     */
    protected $detailCount;

    /**
     * @ORM\OneToMany(targetEntity="CompetitionSessionRound", mappedBy="session")
     */
    protected $rounds;

    /**
     * @ORM\OneToMany(targetEntity="CompetitionSessionEntry", mappedBy="session")
     */
    protected $entries;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rounds = new ArrayCollection();
        $this->entries = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return CompetitionSession
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    
        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set bossCount
     *
     * @param integer $bossCount
     * @return CompetitionSession
     */
    public function setBossCount($bossCount)
    {
        $this->bossCount = $bossCount;
    
        return $this;
    }

    /**
     * Get bossCount
     *
     * @return integer 
     */
    public function getBossCount()
    {
        return $this->bossCount;
    }

    /**
     * Set targetCount
     *
     * @param integer $targetCount
     * @return CompetitionSession
     */
    public function setTargetCount($targetCount)
    {
        $this->targetCount = $targetCount;
    
        return $this;
    }

    /**
     * Get targetCount
     *
     * @return integer 
     */
    public function getTargetCount()
    {
        return $this->targetCount;
    }

    /**
     * Set detailCount
     *
     * @param integer $detailCount
     * @return CompetitionSession
     */
    public function setDetailCount($detailCount)
    {
        $this->detailCount = $detailCount;
    
        return $this;
    }

    /**
     * Get detailCount
     *
     * @return integer 
     */
    public function getDetailCount()
    {
        return $this->detailCount;
    }

    /**
     * Set competition
     *
     * @param Competition $competition
     * @return CompetitionSession
     */
    public function setCompetition(Competition $competition = null)
    {
        $this->competition = $competition;
    
        return $this;
    }

    /**
     * Get competition
     *
     * @return Competition
     */
    public function getCompetition()
    {
        return $this->competition;
    }

    /**
     * Add rounds
     *
     * @param CompetitionSessionRound $rounds
     * @return CompetitionSession
     */
    public function addRound(CompetitionSessionRound $rounds)
    {
        $this->rounds[] = $rounds;
    
        return $this;
    }

    /**
     * Remove rounds
     *
     * @param CompetitionSessionRound $rounds
     */
    public function removeRound(CompetitionSessionRound $rounds)
    {
        $this->rounds->removeElement($rounds);
    }

    /**
     * Get rounds
     *
     * @return \Doctrine\Common\Collections\Collection|CompetitionSessionRound[]
     */
    public function getRounds()
    {
        return $this->rounds;
    }

    /**
     * Add entries
     *
     * @param CompetitionSessionEntry $entries
     * @return CompetitionSession
     */
    public function addEntry(CompetitionSessionEntry $entries)
    {
        $this->entries[] = $entries;
    
        return $this;
    }

    /**
     * Remove entries
     *
     * @param CompetitionSessionEntry $entries
     */
    public function removeEntry(CompetitionSessionEntry $entries)
    {
        $this->entries->removeElement($entries);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection|CompetitionSessionEntry[]
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * @return int
     */
    public function getTotalSpaces(){
        return CompetitionManager::getTotalSpaces($this);
    }
    /**
     * @return int
     */
    public function getFreeSpaces(){
        return CompetitionManager::getFreeSpaces($this);
    }
}
