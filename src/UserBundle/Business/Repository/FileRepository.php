<?php

namespace UserBundle\Business\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Config\Definition\Exception\Exception;
use UserBundle\Entity\Document\File;


/**
 * Class FileRepository
 * @package UserBundle\Business\Repository
 */
class FileRepository extends EntityRepository
{
    const ALIAS = 'file';

    public function save(File $file)
    {
        try {
            $this->_em->persist($file);
            $this->_em->flush();
        } catch (Exception $e){
             return new File();
        }

        return $file;
    }
}