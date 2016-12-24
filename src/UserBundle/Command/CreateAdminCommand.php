<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;

/**
 * Class CreateAdminCommand
 * @package UserBundle\Command
 */
class CreateAdminCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

            $this
                -> setName('agent:create-admin')
                ->setDescription('Promotes a agent by adding a group')
                ->setDefinition(array(
                    new InputArgument('username', InputArgument::REQUIRED, 'The username')
                ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $agent = new Agent();
        $agent->setUsername($username);
        $agent->setEmail($username);
        $agent->setPrivateEmail($username);
        $agent->setPlainPassword($username);
        $agent->setSuperior(null);
        $agent->setAgentId('admin');
        $agent->setFirstName('admin');
        $agent->setNationality('en');
        $agent->setLastName('admin');
        $agent->setEnabled(true);
        $agent->setSocialSecurityNumber('admin');
        $agent->setAgentBackground('admin');
        $agent->setBankName('bank');

        $address = new Address();
        $address->setCity('Belgrade');
        $address->setCountry('Serbia');
        $address->setFixedPhone('+381113480804');
        $address->setPhone('+381113480804');
        $address->setPostcode('12312241241241245');
        $agent->setAddress($address);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $group = $em->getRepository('UserBundle:Group')->findOneBy(array('name'=> 'ADMIN' ));
        if (!$group) {
            throw new \Exception('Group can not be found');
        }
        $agent->setGroup($group);
        $em->getRepository('UserBundle:Agent')->saveAgent($agent);

        $output->writeln('Successfully inserted admin agent to : '.$group);
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('username')) {
            $question = new Question('Please choose a username:');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }

                return $username;
            });
            $questions['username'] = $question;
        }


        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}