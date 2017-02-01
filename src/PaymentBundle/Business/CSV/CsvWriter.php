<?php

namespace PaymentBundle\Business\CSV;

use PaymentBundle\Model\Resource\CSVEntityInterface;

/**
 * Class CsvWriter
 *
 * @package PaymentBundle\Business\CSV
 */
class CsvWriter extends AbstractStreamWriter
{
    protected $delimiter = ';';
    protected $enclosure = '"';
    protected $utf8Encoding = false;

    protected $header = null;

    /**
     * @param string $delimiter
     * @param string $enclosure
     * @param null   $stream
     * @param bool   $utf8Encoding
     */
    public function __construct($delimiter = ',', $enclosure = '"', $stream = null, $utf8Encoding = false)
    {
        parent::__construct($stream);

        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->utf8Encoding = $utf8Encoding;
    }

    /**
     * {@inheritdoc}
     *
     */
    public function prepare()
    {
        if ($this->utf8Encoding) {
            fprintf($this->getStream(), chr(0xEF) . chr(0xBB) . chr(0xBF));
        }

        return $this;
    }


    /**
     * {@inheritdoc}
     */
    public function writeItem(CSVEntityInterface $entity)
    {
        if (is_null($this->header)) {
            $this->header = $entity->getCSVHeader();
            fputcsv($this->getStream(), $this->header, $this->delimiter, $this->enclosure);
        }

        fputcsv($this->getStream(), $entity->getCSVValues(), $this->delimiter, $this->enclosure);

        return $this;

    }

    /**
     * {@inheritdoc}
     */
    public function writeCustomItem($entity)
    {
        foreach ($newArray = array_values($entity) as $key => $item) {
            if ($item instanceof \DateTime) {
                $newArray[$key] = $item->format('Y-m-d H:i:s');
            }
        }
        if (is_null($this->header)) {
            $this->header = array_keys($entity);
            fputcsv($this->getStream(), $this->header, $this->delimiter, $this->enclosure);
        }

        fputcsv($this->getStream(), $newArray, $this->delimiter, $this->enclosure);

        return $this;

    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        unlink($this->tmpFile);
    }


}
