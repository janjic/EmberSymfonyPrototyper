<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class ImportHierarchyCommand
 * @package UserBundle\Business\Command
 */
class ImportHierarchyCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

        $this->setName('import_hierarchy')
            ->setDescription('Import default groups and roles to database !');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /**
         * ROLES
         */
        $adminRole = new Role('ROLE_SUPER_ADMIN');
        $adminRole->setName('ADMIN');
        $ambassadorRole = new Role('ROLE_AMBASSADOR_AGENT');
        $ambassadorRole->setName('AMBASSADOR');
        $masterRole = new Role('ROLE_MASTER_AGENT');
        $masterRole->setName('MASTER');
        $activeRole = new Role('ROLE_ACTIVE_AGENT');
        $activeRole->setName('ACTIVE');
        $refereeRole = new Role('ROLE_REFEREE_AGENT');
        $refereeRole->setName('REFEREE');


        /**
         * SET ROLE HIERARCHY
         */
        $ambassadorRole->setParent($adminRole);
        $masterRole->setParent($ambassadorRole);
        $activeRole->setParent($masterRole);
        $refereeRole->setParent($activeRole);

        /**
         * GROUPS
         */
        $adminGroup = new Group('ADMIN');
        $ambassadorGroup = new Group('AMBASSADOR');
        $masterGroup     = new Group('MASTER');
        $activeGroup     = new Group('ACTIVE');
        $refereeGroup    = new Group('REFEREE');


        $em = $this->getContainer()->get('doctrine')->getManager();
        /**
         * GROUPS AND ROLES
         */
        $adminGroup->addRole($adminRole);
        $ambassadorGroup->addRole($ambassadorRole);
        $masterGroup->addRole($masterRole);
        $activeGroup->addRole($activeRole);
        $refereeGroup->addRole($refereeRole);

        /**
         * PERSISTING ROLES
         */
        $em->persist($adminRole);
        $em->persist($ambassadorRole);
        $em->persist($masterRole);
        $em->persist($activeRole);
        $em->persist($refereeRole);

        /**
         * PERSISTING GROUPS
         */

        $em->persist($adminGroup);
        $em->persist($ambassadorGroup);
        $em->persist($masterGroup);
        $em->persist($activeGroup);
        $em->persist($refereeGroup);

        $em->flush();

        $output->writeln('Successfully imported groups and roles');






    }
}