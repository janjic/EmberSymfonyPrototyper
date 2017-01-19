<?php

namespace UserBundle\Command;

use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use PDO;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Finder\Finder;
use UserBundle\Business\Manager\Agent\SaveMediaTrait;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;
use UserBundle\Entity\Group;
use UserBundle\Helpers\RoleHelper;

/**
 * Class ImportAgentsCommand
 * @package UserBundle\Command
 */
class ImportAgentsCommand extends ContainerAwareCommand
{

    use SaveMediaTrait;
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {

        $this->setName('import_agents')
            ->setDescription('Import default groups and roles to database !')
            ->setDefinition(array(
                new InputArgument('database', InputArgument::REQUIRED, 'The database')
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Doctrine\Bundle\DoctrineBundle\ConnectionFactory $connectionFactory */
        $connectionFactory = $this->getContainer()->get('doctrine.dbal.connection_factory');
        $this->getContainer()->getParameter('database_host');
        $conn = $connectionFactory->createConnection(
            array('pdo' => new PDO('mysql:host='.$this->getContainer()->getParameter('database_host').'.;dbname='.$input->getArgument('database'), $this->getContainer()->getParameter('database_user'), $this->getContainer()->getParameter('database_password')))
        );
        $_SERVER['HTTP_HOST']   = CreateAdminCommand::SERVER;
        $_SERVER['SERVER_NAME'] = CreateAdminCommand::SERVER;
        $_SERVER['HTTPS']       = CreateAdminCommand::HTTPS;
       // $conn = $this->getContainer()->get('doctrine.dbal.agent_db_connection');

        $duplicateEmailsQuery = "SELECT email FROM tcr_agent GROUP BY email HAVING (COUNT(*) >=2);";
        $statement = $conn->prepare($duplicateEmailsQuery);
        $statement->execute();
        $duplicatesEmailsRS = $statement->fetchAll();
        $duplicatesEmail = array();
        foreach ($duplicatesEmailsRS as $emailRow) {
            array_push($duplicatesEmail, $emailRow['email']);
        }
        $statement = $conn->prepare('select * from tcr_agent');
        $statement->execute();
        $agents = $statement->fetchAll();

        $em = $this->getContainer()->get('doctrine')->getManager();
        $HQ = $em->getRepository('UserBundle:Agent')->find(CreateAdminCommand::AGENT_ADMIN_ID);
        $imagesBase64 = array();

        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/avatars/');

        foreach ($finder as $file) {
            $data = file_get_contents($file->getRealPath());
            $type = pathinfo($file->getRealPath(), PATHINFO_EXTENSION);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            array_push($imagesBase64,$base64);
        }
        $groups =  $group = $em->getRepository('UserBundle:Group')->findAll();

        $groupMap = array();
        /** @var Group $group */
        foreach ($groups as $group) {
            $groupMap[$group->getName()] = $group->getId();
        }

        $max =  count($imagesBase64) -1;

        foreach ($agents as $agentRow) {
            if (in_array($agentRow['email'], $duplicatesEmail)) {
                continue;
            }

            $agent = new Agent();
            $agent->setBirthDate(new DateTime('1990-01-20'));
            $agent->setId(intval($agentRow['id']));
            $agent->setUsername($agentRow['email']);
            $agent->setEmail($agentRow['email']);
            $agent->setPrivateEmail($agentRow['email']);
            $agent->setPlainPassword($agentRow['email']);
            $agent->setAgentId($agentRow['agent_id']);
            $agent->setFirstName($agentRow['first_name']);
            $agent->setNationality('en');
            $agent->setLastName($agentRow['last_name']);
            $agent->setEnabled(true);
            $agent->setSocialSecurityNumber($agentRow['agent_id']);
            $agent->setAgentBackground($agentRow['agent_id']);
            $agent->setBankName('bank');
            $agent->setTitle('MR');
            $image = new Image();
            $image->setName('profile_'.$agent->getId(). '.jpg');
            $image->setBase64Content($imagesBase64[random_int(0, $max)]);
            $agent->setImage($image);
            $address = new Address();
            $address->setCity('DEFAULT');
            $address->setCountry('Serbia');
            $address->setFixedPhone('+381113480804');
            $address->setPhone('+381113480804');
            $address->setPostcode('12312241241241245');
            $address->setStreetNumber('12a');
            $agent->setAddress($address);
            $group = $em->getReference(Group::class, $groupMap[RoleHelper::getMappings()[$agentRow['agent_type']]]);
            $agent->setGroup($group);
            $this->saveMedia($agent);
            $em->getRepository('UserBundle:Agent')->saveAgent($agent, $HQ);
            $output->writeln("Successfully inserted  agent: ". $agent->getEmail());
        }

        $metadata = $em->getClassMetaData(Agent::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $em->flush();
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('database')) {
            $question = new Question('Please insert a database name:');
            $question->setValidator(function ($db) {
                if (empty($db)) {
                    throw new \Exception('Database can not be empty');
                }

                return $db;
            });
            $questions['database'] = $question;
        }


        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}