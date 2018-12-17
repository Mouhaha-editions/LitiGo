<?php

namespace CoreBundle\Entity;

use CustomerBundle\Enums\ECustomerCommunicationType;
use CustomerBundle\Enums\ECustomerType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use ProjectBundle\Entity\Comment;
use ProjectBundle\Entity\Project;
use ProjectBundle\Entity\Requete;
use ProjectBundle\Entity\Response;

/**
 * user
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Project[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Project",mappedBy="owner" )
     */
    private $ownedProjects;

    /**
     * @var Project[]
     *
     * @ORM\ManyToMany(targetEntity="ProjectBundle\Entity\Project",mappedBy="participants" )
     */
    private $projects;

    /**
     * @var Requete[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Requete",mappedBy="initiator" )
     */
    private $requests;

    /**
     * @var Response[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Response",mappedBy="author" )
     */
    private $responses;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Comment",mappedBy="author" )
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();
        $this->projects = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->ownedProjects = new ArrayCollection();
    }

    public function getFullname()
    {
        return $this->getUsername();
    }

    /**
     * Add ownedProject.
     *
     * @param \ProjectBundle\Entity\Project $ownedProject
     *
     * @return User
     */
    public function addOwnedProject(\ProjectBundle\Entity\Project $ownedProject)
    {
        $this->ownedProjects[] = $ownedProject;

        return $this;
    }

    /**
     * Remove ownedProject.
     *
     * @param \ProjectBundle\Entity\Project $ownedProject
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOwnedProject(\ProjectBundle\Entity\Project $ownedProject)
    {
        return $this->ownedProjects->removeElement($ownedProject);
    }

    /**
     * Get ownedProjects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOwnedProjects()
    {
        return $this->ownedProjects;
    }

    /**
     * Add project.
     *
     * @param \ProjectBundle\Entity\Project $project
     *
     * @return User
     */
    public function addProject(\ProjectBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project.
     *
     * @param \ProjectBundle\Entity\Project $project
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeProject(\ProjectBundle\Entity\Project $project)
    {
        return $this->projects->removeElement($project);
    }

    /**
     * Get projects.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add request.
     *
     * @param \ProjectBundle\Entity\Requete $request
     *
     * @return User
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
     * Add response.
     *
     * @param \ProjectBundle\Entity\Response $response
     *
     * @return User
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
     * Add comment.
     *
     * @param \ProjectBundle\Entity\Comment $comment
     *
     * @return User
     */
    public function addComment(\ProjectBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \ProjectBundle\Entity\Comment $comment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeComment(\ProjectBundle\Entity\Comment $comment)
    {
        return $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
