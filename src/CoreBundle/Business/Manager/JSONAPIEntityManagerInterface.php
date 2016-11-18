<?php

namespace CoreBundle\Business\Manager;

/**
 * Interface BasicEntityManagerInterface
 *
 * @package Alligator\Model\Core\Resource\Model
 */
interface JSONAPIEntityManagerInterface extends BasicEntityManagerInterface
{
        /**
         * @param null $id
         * @return mixed
         */
        public function getResource($id = null);

        /**
         * @param $data
         * @return mixed
         */
        public function saveResource($data);

        /**
         * @param $data
         * @return mixed
         */
        public function updateResource($data);

        /**
         * @param null $id
         * @return mixed
         */
        public function deleteResource($id = null);

}