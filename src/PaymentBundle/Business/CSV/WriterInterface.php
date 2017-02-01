<?php

namespace PaymentBundle\Business\CSV;

use PaymentBundle\Model\Resource\CSVEntityInterface;
use PaymentBundle\Model\Resource\PrimaryKeyInterface;

/**
 * Interface WriterInterface
 *
 * @package PaymentBundle\Business\CSV
 */
interface WriterInterface
{
    /**
     * Prepare the writer before writing the items
     *
     * @return mixed
     */
    public function prepare();

    /**
     * @param PrimaryKeyInterface $entity
     * @return mixed
     */
    public function writeItem(CSVEntityInterface $entity);

    /**
     * @param PrimaryKeyInterface $entity
     * @return mixed
     */
    public function writeCustomItem($entity);


    /**
     * @param mixed $collection
     *
     * @return mixed
     */
    public function writeCollection($collection);

    /**
     * Wrap up the writer after all items have been written
     *
     * @return $this
     */
    public function finish();
}
