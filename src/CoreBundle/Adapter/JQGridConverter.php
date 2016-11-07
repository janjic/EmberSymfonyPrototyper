<?php

namespace CoreBundle\Adapter;


use Alligator\Adapter\Checkout\AbandonedCartsListJSONConverter;
use Alligator\Adapter\Product\ProductListUncategorizedConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\Debug;

/**
 * Class JQGridConverter
 * @package CoreBundle\Adapter
 */
class JQGridConverter extends BasicConverter
{

    /**
     * @var
     */
    protected $searchFields;

    /**
     * @return mixed
     */
    public function convert()
    {
        $additionalParams = array();
        $page = $this->request->get('page');
        $offset = $this->request->get('rows');
        $sortParams = array($this->searchFields[$this->request->get('sidx')], $this->request->get('sord'));
        $searchParams = null;
        if (filter_var($this->request->get('_search'), FILTER_VALIDATE_BOOLEAN) && $this->request->get('searchField')) {
            $searchParams= array(array('toolbar_search'=>false));
            $searchParams[] = $this->request->request->all();
            $searchParams[1]['searchField'] = $this->searchFields[$searchParams[1]['searchField']];

            $reviewsAll = $this->manager->searchForJQGRID($searchParams, $sortParams, $additionalParams);

        } elseif (filter_var($this->request->get('_search'), FILTER_VALIDATE_BOOLEAN) && ($filters =$this->request->get('filters'))) {
            $searchParams= array(array('toolbar_search'=>true, 'rows'=>$offset, 'page'=>$page), array());
            foreach ($rules = json_decode($filters)->rules as $rule) {
                $searchParams[1][$this->searchFields[$rule->field]] = $rule->data;
            }
            $reviewsAll = $this->manager->searchForJQGRID($searchParams, $sortParams, $additionalParams);

        } else {

            $reviewsAll = $this->manager->findAllForJQGRID($page, $offset, $sortParams, $additionalParams);

            $size = (int) $this->manager->getCountForJQGRID(null, null, $additionalParams)[0][1];

            $pageCount = ceil($size/$offset);

            $reviews = array('items'=>$reviewsAll,'description'=>array('current'=>$page, 'totalCount'=>$size, 'pageCount'=>$pageCount));

            return $this->request->attributes->set($this->param, new ArrayCollection($reviews));
        }

        $size = (int) $this->manager->getCountForJQGRID($searchParams, $sortParams, $additionalParams)[0][1];

        $pageCount = ceil($size/$offset);

        $reviews = array('items'=>$reviewsAll,'description'=>array('current'=>$page, 'totalCount'=>$size, 'pageCount'=>$pageCount));

        $this->request->attributes->set($this->param, new ArrayCollection($reviews));
    }
}