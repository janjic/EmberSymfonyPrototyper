<?php

namespace UserBundle\Command;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use UserBundle\Business\Manager\Agent\SaveMediaTrait;
use UserBundle\Entity\Address;
use UserBundle\Entity\Agent;
use UserBundle\Entity\Document\Image;

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
            ->setDescription('Import default groups and roles to database !');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $_SERVER['HTTP_HOST']   = CreateAdminCommand::SERVER;
        $_SERVER['SERVER_NAME'] = CreateAdminCommand::SERVER;
        $_SERVER['HTTPS']       = CreateAdminCommand::HTTPS;
        $conn = $this->getContainer()->get('doctrine.dbal.agent_db_connection');

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
        $group = $em->getRepository('UserBundle:Group')->findOneBy(array('name'=> 'ACTIVE' ));
        $HQ = $em->getRepository('UserBundle:Agent')->find(CreateAdminCommand::AGENT_ADMIN_ID);
        $picturePath = __DIR__ . '/avatars/user_default.jpg';
        $type = pathinfo($picturePath, PATHINFO_EXTENSION);
        $data = file_get_contents($picturePath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        foreach ($agents as $agentRow) {
            if (in_array($agentRow['email'], $duplicatesEmail)) {
                continue;
            }

            $agent = new Agent();
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
            $image->setBase64Content($base64);
            $agent->setImage($image);
            $address = new Address();
            $address->setCity('DEFAULT');
            $address->setCountry('Serbia');
            $address->setFixedPhone('+381113480804');
            $address->setPhone('+381113480804');
            $address->setPostcode('12312241241241245');
            $address->setStreetNumber('12a');
            $agent->setAddress($address);
            if (!$group) {
                throw new \Exception('Group can not be found');
            }
            $agent->setGroup($group);
            $this->saveMedia($agent);
            $em->getRepository('UserBundle:Agent')->saveAgent($agent, $HQ);
            $output->writeln("Successfully inserted  agent: ". $agent->getEmail());
        }

        $metadata = $em->getClassMetaData(Agent::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $em->flush();
    }
}