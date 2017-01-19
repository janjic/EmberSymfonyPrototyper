<?php


namespace CoreBundle\Command;

use CoreBundle\Adapter\AgentApiCode;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use UserBundle\Entity\Client;

/**
 * Class DumpApiCodesCommand
 * @package AppBundle\Command
 */
class DumpApiCodesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dump:api-codes-to:ember')
            ->setDescription('Dumping api codes to ember');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this
            ->getContainer()
            ->get('api.codes.dumper')
            ->dump(sprintf('%s/../web/js', $this->getContainer()->getParameter('kernel.root_dir')), array('codes'=>(new \ReflectionClass(AgentApiCode::class))->getConstants()));
        /** @var Client $client */
        $client = $this->getContainer()->get('fos_oauth_server.client_manager.default')->findClientBy(array('id'=>1));
        $data  = array('clientId'=> $client->getId().'_'.$client->getRandomId(), 'clientSecret'=>$client->getSecret());

        $this
            ->getContainer()
            ->get('api.codes.dumper')
            ->dump(sprintf('%s/../EmberApp/config', $this->getContainer()->getParameter('kernel.root_dir')), $data, 'environment.js','@Core/templates/environment.js.twig' );
    }
}