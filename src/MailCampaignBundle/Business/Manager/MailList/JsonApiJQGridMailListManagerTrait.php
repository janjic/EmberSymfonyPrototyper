<?php

namespace MailCampaignBundle\Business\Manager\MailList;
use CoreBundle\Adapter\AgentApiResponse;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Exception;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

/**
 * Class JsonApiJQGridMailListManagerTrait
 * @package MailCampaignBundle\Business\Manager\MailList
 */
trait JsonApiJQGridMailListManagerTrait
{
    /**
     * @param $request
     * @return ArrayCollection
     */
    public function jqgridAction($request)
    {
        $params = null;
        $searchParams = null;
        $page = $request->get('page');
        $offset = $request->get('offset');


        $params['page'] = $page;
        $params['offset'] = $offset;

        $agents = $this->findAllForJQGRID($page, $offset);
        $size = (int)$this->findAllForJQGRID($page, $offset, true);
        $pageCount = ceil($size / $offset);

        return new ArrayCollection(array('data' => $agents, 'meta' => array('totalItems'=>$size, 'pages' => $pageCount, 'page' => $page)));
    }
}