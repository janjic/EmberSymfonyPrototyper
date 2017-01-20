<?php

namespace UserBundle\Command;

use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use UserBundle\Business\Manager\Agent\SaveMediaTrait;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;

/**
 * Class CreateAdminCommand
 * @package UserBundle\Command
 */
class CreateAdminCommand extends ContainerAwareCommand
{
    use SaveMediaTrait;

    const AGENT_HQ_CODE = 'ADMIN_HQ_DEFAULT';
    const SERVER = '192.168.11.3';
    const HTTPS  = 'on';
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
        $_SERVER['HTTP_HOST']   = self::SERVER;
        $_SERVER['SERVER_NAME'] = self::SERVER;
        $_SERVER['HTTPS']       = self::HTTPS;
        $picturePath = __DIR__ . '/avatars/user_default.jpg';
        $type = pathinfo($picturePath, PATHINFO_EXTENSION);
        $data = file_get_contents($picturePath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $username = $input->getArgument('username');

        $agent = new Agent();
        $agent->setBirthDate(new DateTime('1990-01-20'));
        $agent->setUsername($username);
        $agent->setEmail($username);
        $agent->setPrivateEmail($username);
        $agent->setPlainPassword($username);
        $agent->setSuperior(null);
        $agent->setAgentId(self::AGENT_HQ_CODE);
        $agent->setFirstName('admin');
        $agent->setNationality('en');
        $agent->setLastName('admin');
        $agent->setEnabled(true);
        $agent->setTitle("MR");
        $agent->setSocialSecurityNumber('admin');
        $agent->setAgentBackground('admin');
        $agent->setBankName('bank');

        $image = new Image();
        $image->setName('profile_'.$agent->getId(). '.jpg');
        $image->setBase64Content($base64);
        $agent->setImage($image);

        $address = new Address();
        $address->setCity('Belgrade');
        $address->setCountry('Serbia');
        $address->setStreetNumber('123a');
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
        $this->saveMedia($agent);

        $syncResult = $this->getContainer()->get('agent_system.agent.manager')->syncWithTCRPortal($agent, 'add');
        if (is_object($syncResult) && $syncResult->code == 200) {
            $agentId = intval($syncResult->agentId);
            $agent->setId(intval($agentId));
            $em->getRepository('UserBundle:Agent')->saveAgent($agent);
            $metadata = $em->getClassMetaData(Agent::class);
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $em->flush();
            $output->writeln('Successfully inserted admin agent to : '.$group);
        }

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