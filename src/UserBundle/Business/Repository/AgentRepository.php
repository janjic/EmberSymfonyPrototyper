<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\Agent;

/**
 * Class GroupRepository
 * @package UserBundle\Business\Repository
 */
class AgentRepository extends EntityRepository
{
    const ALIAS         = 'agent';
    const ADDRESS_ALIAS = 'address';
    const GROUP_ALIAS   = 'group';
    const IMAGE_ALIAS   = 'image';

    /**
     * @param $agent
     * @return Agent
     * @throws \Exception
     */
    public function saveAgent($agent)
    {
        try {
            $this->_em->persist($agent);
            $this->_em->flush();
        } catch (\Exception $e) {

            return new Agent();
        }

        return $agent;
    }

    /**
     * @param $id
     * @return array
     */
    public function findAgentById($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS, self::ADDRESS_ALIAS,  self::IMAGE_ALIAS);
        $qb->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS)
        ->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS)
        ->leftJoin(self::ALIAS.'.image', self::IMAGE_ALIAS);
        $qb->where(self::ALIAS.'.id =:id')
        ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }
}