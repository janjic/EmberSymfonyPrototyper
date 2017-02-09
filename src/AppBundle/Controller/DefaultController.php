<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Repository\RepositoryFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    /**
     * @Route("/api/usersJqgrid", name="users_api_jqgrid")
     */
    public function jqGridAction(Request $request)
    {
        $searchFields = null;
        $additionalParams = null;
        $page = $request->get('page');
        $offset = $request->get('rows');
        $sortParams = array($request->get('sidx'), $request->get('sord'));
        $searchParams = null;

        if (filter_var($request->get('_search'), FILTER_VALIDATE_BOOLEAN) && $request->get('searchField')) {
            $searchParams= array(array('toolbar_search'=>false));
            $searchParams[] = $request->request->all();
            $searchParams[1]['searchField'] = $searchFields[$searchParams[1]['searchField']];

            $reviewsAll = $this->searchForJQGRID($searchParams, $sortParams, $additionalParams);

        } elseif (filter_var($request->get('_search'), FILTER_VALIDATE_BOOLEAN) && ($filters = $request->get('filters'))) {
            $searchParams= array(array('toolbar_search'=>true, 'rows'=>$offset, 'page'=>$page), array());
            foreach ($rules = json_decode($filters)->rules as $rule) {
                $searchParams[1][$searchFields[$rule->field]] = $rule->data;
            }
            $reviewsAll = $this->searchForJQGRID($searchParams, $sortParams, $additionalParams);

        } else {

            $reviewsAll = $this->findAllForJQGRID($page, $offset, $sortParams, $additionalParams);

            $size = (int) $this->getCountForJQGRID(null, null, $additionalParams)[0][1];

            $pageCount = ceil($size/$offset);

            $reviews = array('items'=>$reviewsAll,'description'=>array('current'=>$page, 'totalCount'=>$size, 'pageCount'=>$pageCount));

        }


        $repo = $this->getDoctrine()->getRepository('UserBundle:User');
//        $em = $this->getDoctrine()->getEntityManager();

        $qb = $repo->createQueryBuilder('user');

        $firstResult = 0;
        if ($page != 1) {
            $firstResult = ($page - 1) * $offset;
            //$offset = $page*$offset;
        }

        $qb->select('user.id', 'user.username', 'user.email');

        if ($sortParams[0] == 'category.name') {

            $qb->leftJoin('user.categories', 'category');
        }

        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy('user.' . $sortParams[0], $sortParams[1]);

        $users = $qb->getQuery()->getResult();
        $response = array('items'=>$users,'description'=>array('current'=>$page, 'totalCount'=>10, 'pageCount'=>2));
//        return $qb->getQuery()->getResult();

//        var_dump($response);exit;
        /**return JSON Response */
        return new JsonResponse($response);
    }


    public function searchForJQGRID($searchParams, $sortParams, $additionalParams)
    {

    }

    public function findAllForJQGRID($searchParams, $sortParams, $additionalParams)
    {
        $repo = $this->getDoctrine()->getRepository('UserBundle:User');
        $qb = $repo->createQueryBuilder('user');
    }
}
