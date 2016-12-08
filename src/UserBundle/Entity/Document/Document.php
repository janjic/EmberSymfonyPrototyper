<?php

namespace UserBundle\Entity\Document;

use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Document
 *
 * @package Alligator\Model\Core\Image\Model
 */
class Document
{
    const VERSION = '/ember_proto/';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;


    protected $filePath;

    /**
     * @var double
     * @ORM\Column(name="file_size", type="string", length=255, nullable=true)
     */
    protected $fileSize;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return null === $this->name
            ? null
            : $this->getUploadRootDir() . '/' . $this->name;
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return null === $this->name
            ? null
            : $this->getServer() . '/' . $this->getUploadDir() .Document::VERSION. $this->name;
    }


    /**
     * @return string
     */
    protected function createProFolder()
    {
        $proFolder = $this->getUploadRootDir() .Document::VERSION;
//        var_dump($proFolder);exit;
        if (!file_exists($proFolder)) {

            mkdir($proFolder, 0777, true);
        }

        return $proFolder;
    }


    /**
     * @return string
     */
    public function getUploadDir()
    {
        /**get rid of the __DIR__ so it doesn't screw up when displaying uploaded doc/image inklimacold. the view. */
        return 'uploads/documents';
    }

    /**
     * @return string
     */
    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    private function getServer()
    {
        $isSecure = false;

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $isSecure = true;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            $isSecure = true;
        }
        $protocol = $isSecure ? 'https' : 'http';



        return sprintf($protocol.'://%s', $_SERVER['HTTP_HOST']);
    }

    /**
     * @param string $base64String to decode and save to file
     *
     * @param null   $imageCode
     * @return false|int
     */
    public function saveToFile($base64String, $imageCode = null)
    {
        try {
            list($type, $data) = explode(';', $base64String);
            list(, $extension) = explode('/', $type);
            list(, $data) = explode(',', $data);

            /** string the original data or false on failure */
            $data = base64_decode($data);

            /** find unique name if file already exists */
            $this->setName($this->name ? $this->name : (!$imageCode ? uniqid() : $imageCode) . '.' . $extension);
            $path = $this->createProFolder() . $this->name;

            while (file_exists($this->getAbsolutePathWithVersion())) {
                $this->setName((!$imageCode ? uniqid() : $imageCode) . '.' . $extension);
                $path = $this->createProFolder() . $this->name;
            }

            /**returns the number of bytes that were written to the file, or false on failure */
            return file_put_contents($path, $data);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $base64String to decode and save to file
     * @return false|int
     */
    public function uploadLanguageFileYML($base64String)
    {
        list($type, $data) = explode(';', $base64String);
        list(, $extension) = explode('/', $type);
        list(, $data) = explode(',', $data);

        /** string the original data or false on failure */
        $data = base64_decode($data);

        /** find unique name if file already exists */
        $this->setName(uniqid() . '.' . $extension);
        $path = $this->createProFolder() . '/' . $this->name;

        if (file_exists($path)) {
            $this->setName(uniqid()  . '.' . $extension);
            $path = $this->createProFolder() . '/' . $this->name;
        }

        /**returns the number of bytes that were written to the file, or false on failure */
        return file_put_contents($path, $data);
    }


    /**
     * @param int    $size
     * @param string $extension
     */
    public function setFileName($size, $extension)
    {
        $this->setName($this->name ? $this->name : uniqid() . '.' . $extension);
        $this->filePath = $this->createProFolder() . '/' . $size . ' ' . $this->name;

        if (file_exists($this->filePath)) {
            $this->setName(uniqid() . '.' . $extension);
            $this->filePath = $this->createProFolder() . '/' . $size . ' ' . $this->name;
        }
    }

    /**
     * @param int    $size
     * @param string $extension
     * @param array  $data
     * @param string $type
     * @return string
     */
    public function createThumbnail($size, $extension, $data, $type)
    {

        /** find unique name if file already exists */
        $this->setFileName($size, $extension);

        file_put_contents($this->filePath, $data);

        if ($extension == 'jpeg') {
            $extension = 'jpg';
        }
        switch ($extension) {
            case 'bmp':
                $image = imagecreatefromwbmp($this->filePath);
                break;
            case 'gif':
                $image = imagecreatefromgif($this->filePath);
                break;
            case 'jpg':
                $image = imagecreatefromjpeg($this->filePath);
                break;
            case 'png':
                $image = imagecreatefrompng($this->filePath);
                break;
            default :
                return 'Unsupported picture type!';
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $aspectRatio = $height / $width;

        if ($width <= $size) {
            $newW = $width;
            $newH = $height;
        } else {
            $newW = $size;
            $newH = abs($newW * $aspectRatio);
        }

        $imageP = imagecreatetruecolor($newW, $newH);

        // preserve transparency
        if ($extension == 'gif' or $extension == 'png') {
            imagecolortransparent($imageP, imagecolorallocatealpha($imageP, 0, 0, 0, 127));
            imagealphablending($imageP, false);
            imagesavealpha($imageP, true);
        }

        imagecopyresampled($imageP, $image, 0, 0, 0, 0, $newW, $newH, $width, $height);

        if ($type == 'data:image/jpeg') {
            imagejpeg($imageP, $this->filePath, 100);
        } else if ($type == 'data:image/png') {
            imagepng($imageP, $this->filePath);
        } else if ($type == 'data:image/gif') {
            imagegif($imageP, $this->filePath);
        }
    }

    /**
     * @return string
     */
    public function getLanguageRootDir()
    {
        return __DIR__ . '/../../../../../' . 'app/Resources/translations';

    }


    /**
     * @return float
     */
    public function getPeakMemoryInMegabytes()
    {
        $mem = memory_get_peak_usage();

        return ($mem / 1024) / 1024;
    }

    /**
     * @return int
     */
    public function returnFileSize()
    {

        return @filesize($this->getAbsolutePathWithVersion());
    }

    /**
     * @return null|string
     */
    public function getAbsolutePathWithVersion()
    {
        return null === $this->name
            ? null
            : $this->getUploadRootDir() . Document::VERSION. $this->name;
    }

    /**
     * @return null|string
     */
    public function getAbsolutePathWithoutName()
    {
        return null === $this->name
            ? null
            : $this->getUploadRootDir() . Document::VERSION;
    }

    /**
     * @return float
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param float $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    /**
     * set file size
     */
    public function updateFileSize()
    {
        $this->setFileSize($this->returnFileSize());
    }

    /**
     *
     */
    public function deleteFile()
    {
        if (file_exists($this->getAbsolutePathWithVersion())) {
            unlink($this->getAbsolutePathWithVersion());
        }
    }

}