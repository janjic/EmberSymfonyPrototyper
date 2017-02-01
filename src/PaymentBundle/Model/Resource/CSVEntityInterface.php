<?php

namespace PaymentBundle\Model\Resource;

/**
 * Interface CSVEntityInterface
 *
 * @package PaymentBundle\Model\Resource
 */
interface CSVEntityInterface
{
    /**
     * @return array
     */
    public function getCSVHeader();

    /**
     * @return array
     */
    public function getCSVValues();

    /**
     * @param mixed $csvValues
     * @param mixed $locale
     * @param array $csvHeaders
     * @param array $propertyMappings
     * @return CSVEntityInterface
     */
    public function setCSVValues($csvValues, $locale, $csvHeaders, $propertyMappings = array());


}