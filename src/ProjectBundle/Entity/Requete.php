<?php

namespace ProjectBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 *
 * @ORM\Table(name="request")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\RequestRepository")
 */
class Requete
{

    use TimestampableEntity;

    const TYPE_BUG = 100;
    const TYPE_NEW = 200;
    const TYPE_IDEA = 300;
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=true)
     */
    private $priority;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User",inversedBy="requests" )
     * @ORM\JoinColumn(name="initiator_id",nullable=false)
     */
    private $initiator;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="ProjectBundle\Entity\Project",inversedBy="requests" )
     * @ORM\JoinColumn(name="project_id",nullable=false)
     *
     */
    private $project;

    /**
     * @var Response[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Response",mappedBy="request" )
     * @ORM\OrderBy({"id"="ASC"})
     */
    private $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
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
     * @return Requete
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return Requete
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
     * Set initiator.
     *
     * @param \CoreBundle\Entity\User $initiator
     *
     * @return Requete
     */
    public function setInitiator(\CoreBundle\Entity\User $initiator)
    {
        $this->initiator = $initiator;

        return $this;
    }

    /**
     * Get initiator.
     *
     * @return \CoreBundle\Entity\User
     */
    public function getInitiator()
    {
        return $this->initiator;
    }

    /**
     * Set project.
     *
     * @param \ProjectBundle\Entity\Project $project
     *
     * @return Requete
     */
    public function setProject(\ProjectBundle\Entity\Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return \ProjectBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add response.
     *
     * @param \ProjectBundle\Entity\Response $response
     *
     * @return Requete
     */
    public function addResponse(\ProjectBundle\Entity\Response $response)
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * Remove response.
     *
     * @param \ProjectBundle\Entity\Response $response
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeResponse(\ProjectBundle\Entity\Response $response)
    {
        return $this->responses->removeElement($response);
    }

    /**
     * Get responses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return Requete
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    public function getTypeStr()
    {
        switch ($this->getType()) {
            case self::TYPE_BUG:
                return "Bug";
            case self::TYPE_NEW:
                return "Nouvelle demande";
            case self::TYPE_IDEA:
                return "Idée";
        }
        return "Non reconnnu";
    }

    /**
     * Set priority.
     *
     * @param int|null $priority
     *
     * @return Requete
     */
    public function setPriority($priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority.
     *
     * @return int|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function getLastResponse(){
        return $this->getResponses()->get(0);
    }
}
