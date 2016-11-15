<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\User;


/**
 * Class ImageRepository
 * @package UserBundle\Business\Repository
 */
class ImageRepository extends EntityRepository
{
    const ALIAS = 'image';


    public function save(Image $image)
    {
        try {
            $this->_em->persist($image);
            $this->_em->flush();
        } catch (Exception $e){
             return new Image();
        }

        return $image;

    }
}