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

    const DEFAULT_USER_PARAM = 'all';
    /**
     * @Route("/api/users/{user_param}", name="api_users", defaults={"user_param": "all"}),
     * @param Request $request
     * @return JsonResponse
     */
    public function apiUserAction(Request $request)
    {
        $data = null;
        if (($param = $request->get('user_param')) === self::DEFAULT_USER_PARAM) {
                $data = $this->getDoctrine()->getRepository('AppBundle:User')->findUsers(null);
        } else {
            if ($id = intval($param)) {
                $data = $this->getDoctrine()->getRepository('AppBundle:User')->findUsers($id);
            }
        }

        return new JsonResponse(
            array(
                'user'=>
                   array(
                       'id'=> '1',
                       'username'=>'admin'
                   )

            )

        );
    }

    /**
     * @Route("/api/users", name="users_api")
     */
    public function jqGridAction(Request $request)
    {
        $page = $request->get('page');
        $offset = $request->get('rows');
        $sortParams = array($request[$request->get('sidx')], $request->get('sord'));
        $searchParams = null;

        $repo = $this->getDoctrine()->getRepository('AppBundle:User');
//        $em = $this->getDoctrine()->getEntityManager();

        $qb = $repo->createQueryBuilder('user');

        $firstResult = 0;
        if ($page != 1) {
            $firstResult = ($page - 1) * $offset;
            //$offset = $page*$offset;
        }

        $qb->select('user.id', 'user.name', 'user.description');

        if ($sortParams[0] == 'category.name') {

            $qb->leftJoin('user.categories', 'category');
        }

        $qb->setFirstResult($firstResult)->setMaxResults($offset)->orderBy('user.' . $sortParams[0], $sortParams[1]);

//        return $qb->getQuery()->getResult();

        /**return JSON Response */
        return new JsonResponse($qb->getQuery()->getResult()->toArray());
    }
}
