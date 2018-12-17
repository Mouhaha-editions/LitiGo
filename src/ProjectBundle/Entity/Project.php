<?php

namespace ProjectBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ProjectRepository")
 */
class Project
{
    use TimestampableEntity;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string",length=200, nullable=false)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;
    /**
     * @var boolean
     *
     * @ORM\Column(name="closed", type="boolean", nullable=false)
     */
    private $closed = false;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string",length=200, nullable=true)
     */
    private $reference;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=true)
     */
    private $startDate;   /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User",inversedBy="ownedProjects" )
     * @ORM\JoinColumn(name="owner_id",nullable=false)
     */
    private $owner;

    /**
     * @var Requete
     *
     * @ORM\OneToMany(targetEntity="Requete",mappedBy="project" )
     */
    private $requests;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="CoreBundle\Entity\User",inversedBy="projects" )
     */
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->requests = new ArrayCollection();
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label.
     *
     * @param string $label
     *
     * @return Project
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set reference.
     *
     * @param string|null $reference
     *
     * @return Project
     */
    public function setReference($reference = null)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return string|null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set startDate.
     *
     * @param \DateTime|null $startDate
     *
     * @return Project
     */
    public function setStartDate($startDate = null)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate.
     *
     * @return \DateTime|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set owner.
     *
     * @param \CoreBundle\Entity\User|null $owner
     *
     * @return Project
     */
    public function setOwner(\CoreBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner.
     *
     * @return \CoreBundle\Entity\User|null
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add participant.
     *
     * @param \CoreBundle\Entity\User $participant
     *
     * @return Project
     */
    public function addParticipant(\CoreBundle\Entity\User $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant.
     *
     * @param \CoreBundle\Entity\User $participant
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeParticipant(\CoreBundle\Entity\User $participant)
    {
        return $this->participants->removeElement($participant);
    }

    /**
     * Get participants.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Project
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set closed.
     *
     * @param bool $closed
     *
     * @return Project
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;

        return $this;
    }

    /**
     * Get closed.
     *
     * @return bool
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set endDate.
     *
     * @param \DateTime|null $endDate
     *
     * @return Project
     */
    public function setEndDate($endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Add request.
     *
     * @param \ProjectBundle\Entity\Requete $request
     *
     * @return Project
     */
    public function addRequest(\ProjectBundle\Entity\Requete $request)
    {
        $this->requests[] = $request;

        return $this;
    }

    /**
     * Remove request.
     *
     * @param \ProjectBundle\Entity\Requete $request
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRequest(\ProjectBundle\Entity\Requete $request)
    {
        return $this->requests->removeElement($request);
    }

    /**
     * Get requests.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Get requests.
     *
     * @return \Doctrine\Common\Collections\Collection|Requete[]
     */
    public function getOpenedRequests()
    {
        return $this->requests;
    }
}
