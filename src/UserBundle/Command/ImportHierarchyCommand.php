<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use UserBundle\Business\Manager\RoleManager;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;
use UserBundle\Entity\Settings\Bonus;
use UserBundle\Entity\Settings\Commission;
use UserBundle\Entity\Settings\Settings;
use UserBundle\Helpers\RoleHelper;

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
        $adminRole = new Role(RoleManager::ROLE_SUPER_ADMIN);
        $adminRole->setName(RoleHelper::ADMIN);

        $ambassadorRole = new Role(RoleManager::ROLE_AMBASSADOR);
        $ambassadorRole->setName(RoleHelper::AMBASSADOR);

        $masterRole = new Role(RoleManager::ROLE_MASTER_AGENT);
        $masterRole->setName(RoleHelper::MASTER);

        $activeRole = new Role(RoleManager::ROLE_ACTIVE_AGENT);
        $activeRole->setName(RoleHelper::ACTIVE);

        $refereeRole = new Role(RoleManager::ROLE_REFEREE);
        $refereeRole->setName(RoleHelper::REFEREE);


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
        $adminGroup      = new Group(RoleHelper::ADMIN);
        $ambassadorGroup = new Group(RoleHelper::AMBASSADOR);
        $masterGroup     = new Group(RoleHelper::MASTER);
        $activeGroup     = new Group(RoleHelper::ACTIVE);
        $refereeGroup    = new Group(RoleHelper::REFEREE);


        $em = $this->getContainer()->get('doctrine')->getManager();

        /**
         * GROUPS AND ROLES
         */
        $adminGroup->addRole($adminRole);
        $ambassadorGroup->addRole($ambassadorRole);
        $masterGroup->addRole($masterRole);
        $activeGroup->addRole($activeRole);
        $refereeGroup->addRole($refereeRole);

        /** @var Settings $settings */
        $settings = new Settings();
        $settings->setConfirmationMail('email@provider.com')
            ->setPayPal('www.paypal.com')
            ->setFacebookLink('www.facebook.com')
            ->setEasycall('www.easycall.com')
            ->setLanguage('en')
            ->setTwitterLink('www.twitter.com')
            ->setGPlusLink('www.google.com');

        /** commissions */
        $commissionReferral = new Commission();
        $commissionReferral->setName($refereeGroup->getName());
        $commissionReferral->setSettings($settings)
            ->setGroup($refereeGroup)
            ->setSetupFee(5)
            ->setPackages(5)
            ->setConnect(5)
            ->setStream(10);

        $commissionActiveAgent = new Commission();
        $commissionActiveAgent->setName($activeGroup->getName());
        $commissionActiveAgent->setSettings($settings)
            ->setGroup($activeGroup)
            ->setSetupFee(5)
            ->setPackages(5)
            ->setConnect(5)
            ->setStream(5);

        $commissionMasterAgent = new Commission();
        $commissionMasterAgent->setName($masterGroup->getName());
        $commissionMasterAgent->setSettings($settings)
            ->setGroup($masterGroup)
            ->setSetupFee(2.5)
            ->setPackages(2.5)
            ->setConnect(2.5)
            ->setStream(2.5);

        $commissionAmbassador = new Commission();
        $commissionAmbassador->setName($ambassadorGroup->getName());
        $commissionAmbassador->setSettings($settings)
            ->setGroup($ambassadorGroup)
            ->setSetupFee(1.25)
            ->setPackages(1.25)
            ->setConnect(1.25)
            ->setStream(1.25);

        $settings->addCommission($commissionReferral);
        $settings->addCommission($commissionActiveAgent);
        $settings->addCommission($commissionMasterAgent);
        $settings->addCommission($commissionAmbassador);

        /** bonuses */
        $bonusActiveAgent = new Bonus();
        $bonusActiveAgent->setName($activeGroup->getName());
        $bonusActiveAgent->setSettings($settings)
            ->setGroup($activeGroup)
            ->setAmount(200)
            ->setCurrency('EUR')
            ->setNumberOfCustomers(20)
            ->setPeriod(6);

        $bonusMasterAgent = new Bonus();
        $bonusMasterAgent->setName($masterGroup->getName());
        $bonusMasterAgent->setSettings($settings)
            ->setGroup($masterGroup)
            ->setAmount(200)
            ->setCurrency('EUR')
            ->setNumberOfCustomers(20)
            ->setPeriod(6);

        $bonusAmbassador = new Bonus();
        $bonusAmbassador->setName($ambassadorGroup->getName());
        $bonusAmbassador->setSettings($settings)
            ->setGroup($ambassadorGroup)
            ->setAmount(200)
            ->setCurrency('EUR')
            ->setNumberOfCustomers(20)
            ->setPeriod(6);

        $settings->addBonus($bonusActiveAgent);
        $settings->addBonus($bonusMasterAgent);
        $settings->addBonus($bonusAmbassador);

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

        /**
         * PERSISTING SETTINGS
         */
        $em->persist($settings);

        $em->flush();

        $output->writeln('Successfully imported groups, roles and settings');
    }
}