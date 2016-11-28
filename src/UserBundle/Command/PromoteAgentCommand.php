<?php

namespace UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Group;
use UserBundle\Entity\Role;

/**
 * Class PromoteAgentCommand
 * @package UserBundle\Business\Command
 */
class PromoteAgentCommand extends ContainerAwareCommand
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

            $this
                -> setName('agent:promote')
                ->setDescription('Promotes a agent by adding a group')
                ->setDefinition(array(
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                    new InputArgument('group', InputArgument::OPTIONAL, 'The group'),
                ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $group = strtoupper($input->getArgument('group'));
        $em = $this->getContainer()->get('doctrine')->getManager();
        /** @var Agent $agent */
        $agent = $em->getRepository('UserBundle:Agent')->getUserForProvider($username);
        $group = $em->getRepository('UserBundle:Group')->findOneBy(array('name'=>$group ));
        if (!$group) {
            throw new \Exception('Group can not be found');
        }
        $agent->setGroup($group);
        $em->merge($agent);
        $em->flush();

        $output->writeln('Successfully promoted agent to : '.$group);
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

        if (!$input->getArgument('group')) {
            $question = new Question('Please choose a group:');
            $question->setValidator(function ($group) {
                if (empty($group)) {
                    throw new \Exception('Group can not be empty');
                }

                return $group;
            });
            $questions['group'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}