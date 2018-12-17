<?php
/**
 * Created by PhpStorm.
 * User: pierr
 * Date: 17/12/2018
 * Time: 20:19
 */

namespace ProjectBundle\Service;


use Doctrine\ORM\EntityManager;
use ProjectBundle\Entity\Project;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Security;

class ProjectService
{

    private $em;
    private $security;

    public function __construct(EntityManager $entityManager, Security $security)
    {
        $this->em = $entityManager;
        $this->security = $security;
    }

    /**
     * Am i  the owner ?
     * @param Project $project
     * @return bool
     */
    public function isOwner(Project $project)
    {
        $res = $this->em->getRepository('ProjectBundle:Project')->createQueryBuilder('p')
            ->where('p.owner = :user ')
            ->andWhere('p.id = :project')
            ->setParameter('project', $project)
            ->setParameter('user', $this->security->getUser())
            ->getQuery()->getResult();
        return count($res) > 0;
    }

    /**
     * Am i concerned by this project
     * @param Project $project
     * @return bool
     */
    public function isIn(Project $project)
    {
        $res = $this->em->getRepository('ProjectBundle:Project')->createQueryBuilder('p')
            ->leftJoin('p.participants', 'part')
            ->where('part.id = :user')
            ->andWhere('p.id = :project')
            ->setParameter('project', $project)
            ->setParameter('user', $this->security->getUser())
            ->getQuery()->getResult();
        return count($res) > 0;
    }
}