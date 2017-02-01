<?php

namespace PaymentBundle\Business\CSV;

use Doctrine\Common\Collections\Collection;

/**
 * Class AbstractStreamWriter
 *
 * @package PaymentBundle\Business\CSV
 */
abstract class AbstractStreamWriter implements WriterInterface
{
    private $stream;
    private $closeStreamOnFinish = true;

    protected $tmpFile = 'output';

    /**
     * Constructor
     *
     * @param resource $stream
     */
    public function __construct($stream = null)
    {
        $this->tmpFile= $this->tmpFile.uniqid().'csv';
        if (null !== $stream) {
            $this->setStream($stream);
        }
    }

    /**
     * Set Stream Resource
     *
     * @param mixed $stream
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setStream($stream)
    {
        if (! is_resource($stream) || ! 'stream' == get_resource_type($stream)) {
            throw new \InvalidArgumentException(sprintf(
                'Expects argument to be a stream resource, got %s',
                is_resource($stream) ? get_resource_type($stream) : gettype($stream)
            ));
        }

        $this->stream = $stream;

        return $this;
    }

    /**
     * Get underlying stream resource
     *
     * @return resource
     */
    public function getStream()
    {
        if (null === $this->stream) {
            $this->setStream(fopen('php://temp', 'rb+'));
            $this->setCloseStreamOnFinish(false);
        }

        return $this->stream;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function finish()
    {
        if (is_resource($this->stream) && $this->getCloseStreamOnFinish()) {
            fclose($this->stream);
        }

        return $this;
    }

    /**
     * Should underlying stream be closed on finish?
     *
     * @param bool $closeStreamOnFinish
     *
     * @return bool
     */
    public function setCloseStreamOnFinish($closeStreamOnFinish = true)
    {
        $this->closeStreamOnFinish = (bool) $closeStreamOnFinish;

        return $this;
    }

    /**
     * Is Stream closed on finish?
     *
     * @return bool
     */
    public function getCloseStreamOnFinish()
    {
        return $this->closeStreamOnFinish;
    }

    /**
     * @param mixed $collection
     *
     * @return string
     */
    public static function convertCollection($collection)
    {

        if ($collection instanceof Collection) {
            $array = array();
            foreach ($collection as $item) {
               $array[] = $item->getId();
            }
            $collection = $array;
        }

        return implode(",", $collection);
    }

    /**
     * @param mixed $collection
     *
     * @return string
     */
    public function writeCollection($collection)
    {
        $this->setStream(fopen($this->tmpFile, 'w'));
        foreach ($collection as $item) {
            $this->writeItem($item);
        }

       return $this->finish()->getCSVContent();

    }

    /**
     * @param mixed $collection
     *
     * @return string
     */
    public function writeCustomCollection($collection)
    {
        $this->setStream(fopen($this->tmpFile, 'w'));
        foreach ($collection as $item) {
            $this->writeCustomItem($item);
        }

        return $this->finish()->getCSVContent();

    }

    /**
     * @return string
     */
    private function getCSVContent()
    {
        return file_get_contents($this->tmpFile);
    }



}
