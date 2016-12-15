<?php

namespace ConversationBundle\Business\Repository;

use ConversationBundle\Entity\Message;
use ConversationBundle\Entity\Ticket;
use CoreBundle\Business\Manager\BasicEntityRepositoryTrait;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * Class TicketRepository
 * @package ConversationBundle\Business\Repository
 */
class TicketRepository extends EntityRepository
{
    use BasicEntityRepositoryTrait;

    const ALIAS = 'ticket';
    const JOIN_WITH_AUTHOR = 'createdBy';
    const JOIN_WITH_RECIPIENT = 'forwardedTo';
    const JOIN_WITH_THREAD = 'thread';
    const JOIN_WITH_FILE = 'file';

    /**
     * @param Ticket $ticket
     * @return Ticket|Exception
     */
    public function saveTicket(Ticket $ticket)
    {
        try {
            $this->_em->persist($ticket);
            $this->_em->flush();
        } catch (Exception $e) {
            var_dump($e->getMessage());exit;
            return $e;
        }

        return $ticket;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findTicketById($id)
    {
        $qb = $this->createQueryBuilder(self::ALIAS);
        $qb->select(self::ALIAS);
        $qb->leftJoin(self::ALIAS.'.'.self::JOIN_WITH_AUTHOR, self::JOIN_WITH_AUTHOR)
            ->leftJoin(self::ALIAS.'.'.self::JOIN_WITH_RECIPIENT, self::JOIN_WITH_RECIPIENT)
            ->leftJoin(self::ALIAS.'.'.self::JOIN_WITH_FILE, self::JOIN_WITH_FILE)
            ->leftJoin(self::ALIAS.'.'.self::JOIN_WITH_THREAD, self::JOIN_WITH_THREAD);

        $qb->where(self::ALIAS.'.id =:id')
            ->setParameter('id', $id);
        $ticket = $qb->getQuery()->getOneOrNullResult();

        return $ticket;

    }

    /**
     * @param Ticket $ticket
     * @return Ticket|Exception
     */
    public function editTicket($ticket)
    {
        try {
            $this->_em->merge($ticket);
            $this->_em->flush();
        } catch (Exception $e) {
            return $e;
        }
        return $ticket;
    }
//
//    /**
//     * Remove message
//     * @param Message $message
//     * @return mixed
//     */
//    public function removeMessage($message)
//    {
//        try {
//            $this->_em->remove($message);
//            $this->_em->flush();
//        } catch (\Exception $e) {
//            return $e;
//        }
//
//        return true;
//    }

    /**
     * @param mixed $page
     * @param mixed $offset
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @return array
     */
    public function findAllForJQGRID($page, $offset, $sortParams, $additionalParams)
    {
        $firstResult =0;
        if ($page !=1) {
            $firstResult = ($page-1)*$offset;
            // $offset = $page*$offset;
        }

        $qb= $this->createQueryBuilder(self::ALIAS);
        if (array_key_exists('search_param', $additionalParams)) {
            $qb->andWhere($qb->expr()->like(self::ALIAS.'.username', $qb->expr()->literal('%'.$additionalParams['search_param'].'%')));;
        }

        if ($additionalParams && array_key_exists('ticketsType', $additionalParams)) {
            $additionalParams['agentId'] == 'null'?
                $qb->andWhere(self::ALIAS.'.'.$additionalParams['ticketsType'].' is NULL'):
                $qb->andWhere(self::ALIAS.'.'.$additionalParams['ticketsType'].' = '.$additionalParams['agentId']);
        }

        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy($sortParams[0], $sortParams[1]);
        return $qb->getQuery()->getResult();
    }
    /**
     * @param mixed $searchParams
     * @param mixed $sortParams
     * @param mixed $additionalParams
     * @param bool  $isCountSearch
     * @return array
     */
    public function searchForJQGRID($searchParams, $sortParams, $additionalParams, $isCountSearch = false)
    {
        $oQ0= $this->createQueryBuilder(self::ALIAS);
        if ($additionalParams && array_key_exists('ticketsType', $additionalParams)) {
            $additionalParams['agentId'] == 'null'?
                $oQ0->andWhere(self::ALIAS.'.'.$additionalParams['ticketsType'].' is NULL'):
                $oQ0->andWhere(self::ALIAS.'.'.$additionalParams['ticketsType'].' = '.$additionalParams['agentId']);
        }

        $firstResult = 0;
        $offset = 0;
        if ($searchParams) {
            if ($searchParams[0]['toolbar_search']) {
                $page = $searchParams[0]['page'];
                $offset = $searchParams[0]['rows'];
                $firstResult = 0;
                if ($page != 1) {
                    $firstResult = ($page - 1) * $offset;
                    $offset = $page * $offset;
                }
                array_shift($searchParams);
                foreach ($searchParams[0] as $key => $param) {
                    if(!(($key == 'ticket.status' || $key == 'ticket.type') && $param == -1)){
                        $oQ0->andWhere($oQ0->expr()->like($key, $oQ0->expr()->literal('%'.$param.'%')));
                    }
                }
            } else {
                $searchParams = $searchParams[1];
                $searchField = $searchParams['searchField'];
                $searchString = $searchParams['searchString'];
                $searchOperator = $searchParams['searchOper'];
                $page = $searchParams['page'];
                $offset = $searchParams['rows'];
                $firstResult = 0;
                if ($page != 1) {
                    $firstResult = ($page - 1) * $offset;
                    $offset = $page * $offset;
                }
                //numeric fields
                if (is_numeric($searchString)) {
                    switch ($searchOperator) {
                        case 'eq':
                            $oQ0->andWhere($oQ0->expr()->eq($searchField, $searchString));
                            break;
                        case 'ne':
                            $oQ0->andWhere(
                                $oQ0->expr()->not($oQ0->expr()->eq($searchField, $searchString))
                            );
                            break;
                        case 'nu':
                            $oQ0->andWhere($oQ0->expr()->isNull($searchField));
                            break;
                        case 'nn':
                            $oQ0->andWhere($oQ0->expr()->not($oQ0->expr()->isNull($searchField)));
                            break;
                    }
                }
                //text fields
                if (!is_numeric($searchString)) {
                    switch ($searchOperator) {
                        case 'eq':
                            $oQ0->andWhere(
                                $oQ0->expr()->eq($searchField, $oQ0->expr()->literal($searchString))
                            );
                            break;
                        case 'ne':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->eq($searchField, $oQ0->expr()->literal($searchString))
                                )
                            );
                            break;
                        case 'bw':
                            $oQ0->andWhere(
                                $oQ0->expr()->like($searchField, $oQ0->expr()->literal($searchString.'%'))
                            );
                            break;
                        case 'bn':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $searchField,
                                        $oQ0->expr()->literal($searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'ew':
                            $oQ0->andWhere(
                                $oQ0->expr()->like($this->getAlias().'.'.$searchField, $oQ0->expr()->literal('%'.$searchString))
                            );
                            break;
                        case 'en':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $this->getAlias().'.'.$searchField,
                                        $oQ0->expr()->literal($searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'cn':
                            $oQ0->andWhere(
                                $oQ0->expr()->like(
                                    $searchField,
                                    $oQ0->expr()->literal('%'.$searchString.'%')
                                )
                            );
                            break;
                        case 'nc':
                            $oQ0->andWhere(
                                $oQ0->expr()->not(
                                    $oQ0->expr()->like(
                                        $searchField,
                                        $oQ0->expr()->literal('%'.$searchString.'%')
                                    )
                                )
                            );
                            break;
                        case 'nu':
                            $oQ0->andWhere($oQ0->expr()->isNull($searchField));
                            break;
                        case 'nn':
                            $oQ0->andWhere($oQ0->expr()->not($oQ0->expr()->isNull($searchField)));
                            break;
                    }
                }
            }
        }
        if ($isCountSearch) {
            $oQ0->select('COUNT(DISTINCT '.self::ALIAS.')');
        } else {
            $oQ0->setFirstResult($firstResult)->setMaxResults($offset);
        }
        if ($sortParams) {
            $oQ0->orderBy($sortParams[0], $sortParams[1]);
        }
//        var_dump($oQ0->getQuery()->getSQL());exit;
        return $oQ0->getQuery()->getResult();
    }


}