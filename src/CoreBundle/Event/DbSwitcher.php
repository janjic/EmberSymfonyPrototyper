<?php

namespace CoreBundle\Event;

use Doctrine\DBAL\Connection;
use Exception;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


/**
 * Class DbSwitcher
 * @package CoreBundle\Event
 */
class DbSwitcher {

    private $connection;

    /**
     * DatabaseSwitcherEventListener constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param GetResponseEvent $event
     * @throws Exception
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
//        if ($event->isMasterRequest() && !$event->getRequest()->isXmlHttpRequest()) {
        if ($event->isMasterRequest()) {
        $connection = $this->connection;
            if ($connection->isConnected()) {
                $connection->close();
            }
            $params     = $this->connection->getParams();
            $params['dbname'] = 'test1';
            $connection->__construct(
                $params, $connection->getDriver(), $connection->getConfiguration(),
                $connection->getEventManager()
            );

            try {
                $connection->connect();
            } catch (Exception $e) {
            }
        }
    }
}