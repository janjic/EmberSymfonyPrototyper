<?php

namespace UserBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table("al_image")
 * @ORM\Entity(repositoryClass="UserBundle\Business\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image extends Document implements \Serializable
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="position", type="string", length=255, nullable=true)
     */
    private $position;


    /**
     * @var string
     */
    private $base64Content = null;


    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Image
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getBase64Content()
    {
        return $this->base64Content;
    }

    /**
     * @param string $base64Content
     * @return $this
     */
    public function setBase64Content($base64Content)
    {
        $this->base64Content = $base64Content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;

    }



    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     *
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->name,
            $this->position
        ));
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     *
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->name,
            $this->position
            ) = unserialize($serialized);

    }

    /**
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }


}
