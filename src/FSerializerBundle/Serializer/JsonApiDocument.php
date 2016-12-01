<?php

namespace FSerializerBundle\Serializer;
use Exception;
use ReflectionClass;
use RuntimeException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

use JsonSerializable;

class JsonApiDocument implements JsonSerializable
{
    use JsonApiLinkTrait;
    use JsonApiMetaTrait;

    /**
     * The included array.
     *
     * @var array
     */
    protected $included = [];
    /**
     * The errors array.
     *
     * @var array
     */
    protected $errors;

    /**
     * The jsonapi array.
     *
     * @var array
     */
    protected $jsonApi;

    /**
     * The data object.
     *
     * @var JsonApiElementInterface
     */
    protected $data;

    /**
     * @var
     */
    private $propertyTypeExtractor;

    /**
     * @param JsonApiElementInterface $data
     */
    public function __construct(JsonApiElementInterface $data = null)
    {
        $this->data = $data;
        $reflectionExtractor = new ReflectionExtractor();
        // array of PropertyListExtractorInterface
        $listExtractors = array($reflectionExtractor);
        // array of PropertyTypeExtractorInterface
        $typeExtractors = array($reflectionExtractor);
        // array of PropertyAccessExtractorInterface
        $accessExtractors = array($reflectionExtractor);

        $this->propertyTypeExtractor = new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            $accessExtractors
        );
    }

    /**
     * Get included resources.
     *
     * @param JsonApiElementInterface $element
     * @param bool $includeParent
     *
     * @return JsonApiOne[]
     */
    protected function getIncluded(JsonApiElementInterface $element, $includeParent = false)
    {
        $included = [];
        $type = null;
        $id = null;
        /** @var JsonApiOne $resource */
        foreach ($element->getResources() as $resource) {
            if ($resource->isIdentifier()) {
                continue;
            }
            if ($includeParent) {
                $included = $this->mergeResource($included, $resource);
            } else {
                $type = $resource->getType();
                $id = $resource->getId();
            }
            foreach ($resource->getUnfilteredRelationships() as $relationship) {
                $includedElement = $relationship->getData();
                if (! $includedElement instanceof JsonApiElementInterface) {
                    continue;
                }
                foreach ($this->getIncluded($includedElement, true) as $child) {
                    // If this resource is the same as the top-level "data"
                    // resource, then we don't want it to show up again in the
                    // "included" array.
                    if (! $includeParent && $child->getType() === $type && $child->getId() === $id) {
                        continue;
                    }
                    $included = $this->mergeResource($included, $child);
                }
            }
        }
        $flattened = [];
        array_walk_recursive($included, function ($a) use (&$flattened) {
            $flattened[] = $a;
        });

        return $flattened;
    }
    /**
     * @param JsonApiOne[] $resources
     * @param JsonApiOne $newResource
     *
     * @return JsonApiOne[]
     */
    protected function mergeResource(array $resources, JsonApiOne $newResource)
    {
        $type = $newResource->getType();
        $id = $newResource->getId();
        if (isset($resources[$type][$id])) {
            /** @var JsonApiOne $resource */
            $resource = $resources[$type][$id];
            $resource->merge($newResource);
        } else {
            $resources[$type][$id] = $newResource;
        }
        return $resources;
    }
    /**
     * Set the data object.
     *
     * @param JsonApiElementInterface $element
     *
     * @return $this
     */
    public function setData(JsonApiElementInterface $element)
    {
        $this->data = $element;
        return $this;
    }
    /**
     * Set the errors array.
     *
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }
    /**
     * Set the jsonApi array.
     *
     * @param array $jsonApi
     *
     * @return $this
     */
    public function setJsonApi($jsonApi)
    {
        $this->jsonApi = $jsonApi;
        return $this;
    }
    /**
     * Map everything to arrays.
     *
     * @return array
     */
    public function toArray()
    {

        $document = [];
        if (! empty($this->links)) {
            $document['links'] = $this->links;
        }
        if (! empty($this->data)) {
            $document['data'] = $this->data->toArray();
            $resources = $this->getIncluded($this->data);
            if (count($resources)) {
                $document['included'] = array_map(function (JsonApiOne $resource) {
                    return $resource->toArray();
                }, $resources);
            }
        }
        if (! empty($this->meta)) {
            $document['meta'] = $this->meta;
        }
        if (! empty($this->errors)) {
            $document['errors'] = $this->errors;
        }
        if (! empty($this->jsonapi)) {
            $document['jsonapi'] = $this->jsonapi;
        }
        return $document;
    }
    /**
     * Map to string.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
    /**
     * Serialize for JSON usage.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param null $string
     * @return array
     * @throws \Exception
     * @internal param null $data
     */
    public function deserialize($string=null)
    {
        if (is_null($string)) {
            throw new \Exception('Please provide data to deserializer');
        }
        $decoded = (array)json_decode($string,true);

        $type = array_key_exists(0, $decoded['data']) ?$decoded['data'][0]['type']:$decoded['data']['type'];
        if (!$type) {
            throw new Exception('Document type does not exist in json api');
        }
        $this->data->getSerializer()->setType($type);


        $mappings = $this->data->getSerializer()->getMappings();
        foreach ($mappings as $key =>$mapping) {
            if ($mapping['type'] == $this->data->getSerializer()->getType() ) {
                $this->data->getSerializer()->setDeserializationClass($mapping['class']);
                break;
            }
        }

        if (!$this->data->getSerializer()->getDeserializationClass()) {

            throw  new Exception('Set deserialization class to F-Serializer');
        }

        if (!$this->data->getSerializer()->getType()) {
            throw  new Exception('Set default document type for serializer before calling deserilization');
        }

        if (! empty($this->data)) {
            if (array_key_exists(0,$decoded['data'])) {
                $objects = array();
                $included = array_key_exists('included', $decoded) ? $decoded['included']:array();
                foreach ($decoded['data'] as $decodedData) {
                    array_push($objects, $this->denormalize($this->data, $decodedData, $included));
                }
                return $objects;
            } else {
                return $this->denormalize($this->data, $decoded);
            }


        }

        return null;
    }


    /**
     * @param JsonApiElementInterface $element
     * @param array $decoded
     * @param null $includedData
     * @return array
     * @internal param null $included
     */
    protected function denormalize(JsonApiElementInterface $element, $decoded, $includedData = null )
    {
        if (!$decoded) {
            return null;
        }
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $type = null;
        $id = null;
        $newObject = null;
        /** @var JsonApiOne $resource */
        foreach ($element->getResources() as $resource) {
            $decodedResource = array_key_exists('data',$decoded) ? $decoded['data'] : $decoded;
            $decodedRelationships = array_key_exists('data',$decoded) ? (array_key_exists('relationships',$decoded['data'])?$decoded['data']['relationships']:array()) : (array_key_exists('relationships',$decoded)?$decoded['relationships']:array());
            $decodedIncludedData = $includedData ? $includedData : (array_key_exists('included', $decoded)?$decoded['included']: false);
            if ($decodedIncludedData === false) {
                $decodedIncludedData = array();
                foreach ($decodedRelationships as $key=> $value) {
                    if (array_key_exists('data', $value) && sizeof($value['data'])) {
                        foreach ($value['data'] as $dataKey => $dataValue) {
                            $decodedIncludedData[] = $dataValue;
                        };

                    }

                }
            }

            $newObject = $this->populateAttributes($resource, $decodedResource, $propertyAccessor);

            /** @var JsonApiRelationship $relationship Relationship must implement JsonApiElementInterface */
            foreach ($resource->getUnfilteredRelationships() as $relationship) {
                $relationshipObject = $this->denormalize($relationship->getData(),$relationship->getDenormalizedData($decodedRelationships, $decodedIncludedData),$decodedIncludedData);
                try {
                    $propertyAccessor->setValue($newObject, $relationship->getName(), $relationshipObject);
                } catch (Exception $exception) {
                    // Properties not found are ignored
                }

            }
        }

        return $newObject;
    }


    /**
     * @param $object
     * @param JsonApiElementInterface $resource
     * @return array
     */
    protected function extractAttributes($object, $resource)
    {
        $serializerAttributes = array_keys($resource->getSerializer()->getAttributes($object));
        // If not using groups, detect manually
        $attributes = array();

        // methods
        $reflectionClass = new \ReflectionClass($object);
        foreach ($reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflectionMethod) {
            if (
                $reflectionMethod->getNumberOfRequiredParameters() !== 0 ||
                $reflectionMethod->isStatic() ||
                $reflectionMethod->isConstructor() ||
                $reflectionMethod->isDestructor()
            ) {
                continue;
            }

            $name = $reflectionMethod->name;
            $attributeName = null;

            if (0 === strpos($name, 'get') || 0 === strpos($name, 'has')) {
                // getters and hassers
                $attributeName = lcfirst(substr($name, 3));
            } elseif (strpos($name, 'is') === 0) {
                // issers
                $attributeName = lcfirst(substr($name, 2));
            }


            if (null !== $attributeName && $this->isAllowedAttribute($attributeName, $serializerAttributes)) {
                $attributes[$attributeName] = true;
            }
        }

        // properties
        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            if ($reflectionProperty->isStatic() || $this->isAllowedAttribute($reflectionProperty->name, $serializerAttributes)) {
                continue;
            }
        }

        return $attributes;
    }

    /**
     * @param $attributeName
     * @param $serializerAttributes
     * @return bool
     */
    public function isAllowedAttribute($attributeName, $serializerAttributes)
    {
        return in_array($attributeName, $serializerAttributes);
    }

    /**
     * @param $data

     * @param ReflectionClass $reflectionClass
     * @return mixed
     */
    private function createInstance($data, $reflectionClass)
    {
        if(is_null($data)) {
            return null;
        }

        $class = $reflectionClass->getName();
        $constructor = $reflectionClass->getConstructor();
        $constructorParameters = $constructor ? $constructor->getParameters(): array();
        $params = array();
        foreach ($constructorParameters as $constructorParameter) {

            $paramName = $constructorParameter->name;
            $allowed = $data === false || array_key_exists($paramName, $data);
            if (method_exists($constructorParameter, 'isVariadic') && $constructorParameter->isVariadic()) {
                if ($allowed  && (isset($data[$paramName]) || array_key_exists($paramName, $data))) {
                    if (!is_array($data[$paramName])) {
                        throw new RuntimeException(sprintf('Cannot create an instance of %s from serialized data because the variadic parameter %s can only accept an array.', $class, $constructorParameter->name));
                    }

                    $params = array_merge($params, $data[$paramName]);
                }
            } elseif ($allowed  && (isset($data[$paramName]) || array_key_exists($paramName, $data))) {
                $params[] = $data[$paramName];
                // don't run set for a parameter passed to the constructor
            } elseif ($constructorParameter->isDefaultValueAvailable()) {
                $params[] = $constructorParameter->getDefaultValue();
            } else {
                throw new RuntimeException(
                    sprintf(
                        'Cannot create an instance of %s from serialized data because its constructor requires parameter "%s" to be present.',
                        $class,
                        $constructorParameter->name
                    )
                );
            }
        }

        return $reflectionClass->newInstanceArgs($params);
    }

    /**
     * @param JsonApiElementInterface $resource
     * @param $decoded
     * @param PropertyAccessor $propertyAccessor
     * @return mixed
     */
    private function populateAttributes($resource, $decoded, PropertyAccessor $propertyAccessor)
    {
        if (!$decoded) {
            return null;
        }

        $serializer = $resource->getSerializer();
        if (array_key_exists(0, $decoded)) {
            $resourceObject = array();
            foreach ($decoded as $decodedArray) {
                if (!is_array($decodedArray)) {
                    continue;
                }
                foreach ($decodedArray as $decodedObject) {
                    $data = array_key_exists('attributes',$decodedObject) ?$decodedObject['attributes']:array();
                    $class = $serializer->getDeserializationClass();
                    $newObject = $this->createInstance($data, new ReflectionClass($class));
                    try {
                        $propertyAccessor->setValue($newObject, 'id', intval($decodedObject['id']));
                    } catch (Exception $exception) {
                        // Properties not found are ignored
                    }
                    $objectAttributes = $this->extractAttributes($newObject, $resource);

                    foreach ($objectAttributes as $attribute => $value) {
                        try {
                            $propertyAccessor->setValue($newObject, $attribute, $decodedObject['attributes'][$attribute]);
                        } catch (Exception $exception) {
                            // Properties not found are ignored
                        }


                    }
                    array_push($resourceObject,$newObject);
            }
            }

        } else {
            $data = $decoded['attributes'];
            $class = $serializer->getDeserializationClass();
            $newObject = $this->createInstance($data, new ReflectionClass($class));
            try {
                $propertyAccessor->setValue($newObject, 'id', intval($decoded['id']));
            } catch (Exception $exception) {
                // Properties not found are ignored
            }

            $objectAttributes = $this->extractAttributes($newObject, $resource);

            foreach ($objectAttributes as $attribute => $value) {
                try {
                    $propertyAccessor->setValue($newObject, $attribute, $decoded['attributes'][$attribute]);
                } catch (Exception $exception) {
                    // Properties not found are ignored
                }

            }
            $resourceObject = $newObject;

        }
        $resource->setData($resourceObject);

        return $resourceObject;
    }
}