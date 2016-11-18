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
    const ALIAS          = 'agent';
    const ADDRESS_ALIAS  = 'address';
    const GROUP_ALIAS    = 'g';
    const IMAGE_ALIAS    = 'image';
    const SUPERIOR_ALIAS = 'superior';

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
            throw $e;
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
        $qb->select(self::ALIAS, self::ADDRESS_ALIAS, self::IMAGE_ALIAS, self::GROUP_ALIAS, self::SUPERIOR_ALIAS);
        $qb->leftJoin(self::ALIAS.'.address', self::ADDRESS_ALIAS)
        ->leftJoin(self::ALIAS.'.group', self::GROUP_ALIAS)
        ->leftJoin(self::ALIAS.'.superior', self::SUPERIOR_ALIAS)
        ->leftJoin(self::ALIAS.'.image', self::IMAGE_ALIAS);

        if(intval($id)) {
            $qb->where(self::ALIAS.'.id =:id')
                ->setParameter('id', $id);

            return $qb->getQuery()->getOneOrNullResult();
        }


        return $qb->getQuery()->getResult();
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function edit(Agent $agent)
    {
        try {
            $this->_em->merge($agent);
            $this->_em->flush();
        } catch (\Exception $e) {

            return new Agent();
        }

        return $agent;
    }
}