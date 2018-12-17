<?php

namespace ProjectBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 *
 * @ORM\Table(name="response")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ResponseRepository")
 */
class Response
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
     * @ORM\Column(name="formatted_text", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var Requete
     *
     * @ORM\ManyToOne(targetEntity="Requete",inversedBy="responses" )
     * @ORM\JoinColumn(name="request_id",nullable=true)
     */
    private $request;

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity="ProjectBundle\Entity\Comment",mappedBy="response" )
     * @ORM\OrderBy({"id"="ASC"})
     */
    private $comments;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User",inversedBy="responses" )
     * @ORM\JoinColumn(name="author_id",nullable=false)
     */
    private $author;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
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
     * Set comment.
     *
     * @param string|null $comment
     *
     * @return Response
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set request.
     *
     * @param \ProjectBundle\Entity\Requete|null $request
     *
     * @return Response
     */
    public function setRequest(Requete $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request.
     *
     * @return \ProjectBundle\Entity\Requete|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set author.
     *
     * @param \CoreBundle\Entity\User $author
     *
     * @return Response
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return \CoreBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }


    /**
     * Add comment.
     *
     * @param \ProjectBundle\Entity\Comment $comment
     *
     * @return Response
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
