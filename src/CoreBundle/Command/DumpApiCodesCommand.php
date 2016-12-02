<?php


namespace CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->dump(sprintf('%s/../web/js', $this->getContainer()->getParameter('kernel.root_dir')));
    }
}