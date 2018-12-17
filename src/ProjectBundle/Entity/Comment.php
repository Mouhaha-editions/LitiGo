<?php

namespace ProjectBundle\Entity;

use CoreBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 *
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var Response
     *
     * @ORM\ManyToOne(targetEntity="ProjectBundle\Entity\Response",inversedBy="comments" )
     * @ORM\JoinColumn(name="response_id",nullable=true)
     */
    private $response;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User",inversedBy="comments" )
     * @ORM\JoinColumn(name="author_id",nullable=false)
     */
    private $author;

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
     * @return Comment
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
     * Set author.
     *
     * @param \CoreBundle\Entity\User $author
     *
     * @return Comment
     */
    public function setAuthor(\CoreBundle\Entity\User $author)
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
     * Set response.
     *
     * @param \ProjectBundle\Entity\Response|null $response
     *
     * @return Comment
     */
    public function setResponse(\ProjectBundle\Entity\Response $response = null)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response.
     *
     * @return \ProjectBundle\Entity\Response|null
     */
    public function getResponse()
    {
        return $this->response;
    }
}
