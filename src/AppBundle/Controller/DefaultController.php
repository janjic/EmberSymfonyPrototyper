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
//    /**
//    * @Route("/", name="homepage")
//     */
//    public function indexAction(Request $request)
//    {
//        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', [
//            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
//        ]);
//    }

    /**
     * @Route("/api/test", name="api_test")
     */
    public function apiTestAction(Request $request)
    {
        // replace this example code with whatever you need
        return new JsonResponse(
            array(
                'type' => array(
                    'id'=>1
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
