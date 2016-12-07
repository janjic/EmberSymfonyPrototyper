<?php

namespace FSerializerBundle\Serializer;

interface JsonApiSerializationInterface
{
    /**
     * Get the type.
     *
     * @param mixed $model
     *
     * @return string
     */
    public function getType($model=null);

    /**
     * Get the id.
     *
     * @param mixed $model
     *
     * @return string
     */
    public function getId($model);

    /**
     * Get the attributes array.
     *
     * @param mixed $model
     * @param array|null $fields
     *
     * @return array
     */
    public function getAttributes($model, array $fields = null);

    /**
     * Get the links array.
     *
     * @param mixed $model
     *
     * @return array
     */
    public function getLinks($model);

    /**
     * Get the meta.
     *
     * @param mixed $model
     *
     * @return array
     */
    public function getMeta($model);


    /**
     * @param string $type
     * @return mixed
     */
    public function setType(string $type);


    /**
     * Get a relationship.
     *
     * @param mixed $model
     * @param string $name
     *
     * @return JsonApiRelationship|null
     */
    public function getRelationship($model, $name);


    /**
     * @return mixed
     */
    public function getDeserializationClass();
}