<?php


namespace CoreBundle\Connection;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class ConnectionFactory
 * @package CoreBundle\Connection
 */
class ConnectionFactory
{
    private $typesConfig = array();
    private $commentedTypes = array();
    private $initialized = false;

    /** @var null|\Symfony\Component\HttpFoundation\Request  */
    private $request;
    /**
     * Construct.
     *
     * @param array $typesConfig
     * @param RequestStack $requestStack
     */
    public function __construct(array $typesConfig, RequestStack $requestStack)
    {
        $this->typesConfig = $typesConfig;
        $this->request     = $requestStack->getCurrentRequest();
    }

    /**
     * Create a connection by name.
     *
     * @param array         $params
     * @param Configuration $config
     * @param EventManager  $eventManager
     * @param array         $mappingTypes
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function createConnection(array $params, Configuration $config = null, EventManager $eventManager = null, array $mappingTypes = array())
    {
        if (!$this->initialized) {
            $this->initializeTypes();
            $this->initialized = true;
        }
        if ($this->request) {
            $params['dbname'] = 'test1';
        }

        $connection = DriverManager::getConnection($params, $config, $eventManager);

        if (!empty($mappingTypes)) {
            $platform = $connection->getDatabasePlatform();
            foreach ($mappingTypes as $dbType => $doctrineType) {
                $platform->registerDoctrineTypeMapping($dbType, $doctrineType);
            }
            foreach ($this->commentedTypes as $type) {
                $platform->markDoctrineTypeCommented(Type::getType($type));
            }
        }

        return $connection;
    }

    /**
     * initialize the types
     */
    private function initializeTypes()
    {
        foreach ($this->typesConfig as $type => $typeConfig) {
            if (Type::hasType($type)) {
                Type::overrideType($type, $typeConfig['class']);
            } else {
                Type::addType($type, $typeConfig['class']);
            }
            if ($typeConfig['commented']) {
                $this->commentedTypes[] = $type;
            }
        }
    }
}
