<?php

namespace UserBundle\Business\Repository\Traits;
use CoreBundle\Adapter\AgentApiResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;
use Exception;
use UserBundle\Business\Event\Agent\AgentEvents;
use UserBundle\Business\Event\Agent\AgentGroupChangeEvent;
use UserBundle\Business\Util\AgentSerializerInfo;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Helpers\RoleHelper;

/**
 * Class AgentOrgchartRepositoryTrait
 * @package UserBundle\Business\Repository\Traits
 */
trait AgentOrgchartRepositoryTrait
{
    /**
     * @return array
     */
    public function loadRootAndChildren()
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS.'.id', 'CONCAT('.self::ALIAS.'.firstName'.', \' \', '.self::ALIAS.'.lastName'.') AS name',
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount',  self::ALIAS.'.email', self::SUPERIOR_ALIAS.'.id as superior_id',
            self::ALIAS.'.baseImageUrl', self::ALIAS.'.enabled', self::GROUP_ALIAS.'.name AS groupName');
        $qb->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);

        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);

        $qb->where(self::SUPERIOR_ALIAS.'.superior is NULL');
        $qb->orWhere(self::ALIAS.'.superior is NULL');

        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $parent
     * @param $includeParent
     * @return array
     */
    public function loadChildren($parent, $includeParent)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS.'.id', 'CONCAT('.self::ALIAS.'.firstName'.', \' \', '.self::ALIAS.'.lastName'.') AS name',
            'COUNT('.self::CHILDREN_ALIAS.'.id) as childrenCount', self::ALIAS.'.email', self::ALIAS.'.baseImageUrl',
            self::ALIAS.'.enabled', self::GROUP_ALIAS.'.name AS groupName', self::SUPERIOR_ALIAS.'.id as parentId');

        $qb->leftJoin(self::ALIAS.'.children', self::CHILDREN_ALIAS);
        $qb->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);

        $qb->where(self::ALIAS.'.superior =?1');
        $qb->setParameter(1, $parent);

        if ($includeParent) {
            $qb->orWhere(self::ALIAS.'.id =?2');
            $qb->setParameter(2, $parent);
        }

        $qb->groupBy(self::ALIAS.'.id');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $parentId
     * @return array
     */
    public function loadOrgchartParent($parentId)
    {
        /** @var QueryBuilder $qb */
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(
            self::ALIAS.'.id',
            'CONCAT('.self::ALIAS.'.firstName'.', \' \', '.self::ALIAS.'.lastName'.') AS name',
            self::ALIAS.'.email',
            self::ALIAS.'.baseImageUrl',
            self::ALIAS.'.enabled',
            self::GROUP_ALIAS.'.name AS groupName',
            self::SUPERIOR_ALIAS.'.id as parentId'
        );

        $qb->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS);


        $qb->where(self::ALIAS.'.id =?2');
        $qb->setParameter(2, $parentId);

        return $qb->getQuery()->getSingleResult();
    }
}