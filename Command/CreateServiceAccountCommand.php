<?php

namespace Inwendo\Auth\LoginBundle\Command;

use Inwendo\Auth\LoginBundle\Entity\ServiceAccount;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


class CreateServiceAccountCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('inwendo:auth:login:service:account:create')
            ->setDescription('Create a Service Account with a selected DataClass.')
            ->setDefinition(array(
                new InputArgument('localuser', InputArgument::REQUIRED, 'The local userid or username'),
                new InputArgument('dataclass', InputArgument::REQUIRED, 'The PHP Service-Class to create'),
                new InputArgument('username', InputArgument::REQUIRED, 'The username to use for the service'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password to use for the service'),

            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $dataclass = $input->getArgument('dataclass');
        $localuser = $input->getArgument('localuser');


        $userrepository = $this->getContainer()->getParameter("inwendo_auth_login.userrepository");


        if (!is_subclass_of($dataclass, 'Inwendo\Auth\LoginBundle\Entity\ServiceAccount')) {
            throw new \Exception('The PHP dataclass must extend Inwendo\Auth\LoginBundle\Entity\ServiceAccount');
        }
        // find User by id or username
        $user = $this->getContainer()->get("doctrine")->getRepository($userrepository)->findOneBy(array("id" => $localuser));
        if($user == null){
            $user = $this->getContainer()->get("doctrine")->getRepository($userrepository)->findOneBy(array("username" => $localuser));
            if($user == null){
                throw new \Exception('No user with the id or username found');
            }
        }

        /** @var ServiceAccount $serviceAccount */
        $serviceAccount = new $dataclass();
        $serviceAccountRepo = $serviceAccount->getRepository($this->getContainer()->get("doctrine")->getManager());

        /** @var ServiceAccount $existingAccount */
        $existingAccount = $serviceAccountRepo->findOneBy(array("localUserId" => $user->getId()));
        if($existingAccount != null){
            $existingAccount->setPassword($password);
            $existingAccount->setUsername($username);
        }else{
            $serviceAccount->setPassword($password);
            $serviceAccount->setUsername($username);
            $serviceAccount->setLocalUserId($user->getId());
            $this->getContainer()->get("doctrine")->getManager()->persist($serviceAccount);
        }
        $this->getContainer()->get("doctrine")->getManager()->flush();

        $output->writeln(sprintf('Created Service Account for User with id: <comment>%s</comment>', $user->getId()));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questions = array();

        if (!$input->getArgument('localuser')) {
            $question = new Question('Please choose a local user to add:');
            $question->setValidator(function ($localuser) {
                if (empty($localuser)) {
                    throw new \Exception('Localuser can not be empty');
                }

                return $localuser;
            });
            $questions['localuser'] = $question;
        }

        if (!$input->getArgument('dataclass')) {
            $question = new Question('Please choose a PHP dataclass:');
            $question->setValidator(function ($dataclass) {
                if (empty($dataclass)) {
                    throw new \Exception('The PHP dataclass must exist');
                }
                if (!is_subclass_of($dataclass, 'Inwendo\Auth\LoginBundle\Entity\ServiceAccount')) {
                    throw new \Exception('The PHP dataclass must extend Inwendo\Auth\LoginBundle\Entity\ServiceAccount');
                }

                return $dataclass;
            });
            $questions['dataclass'] = $question;
        }



        if (!$input->getArgument('username')) {
            $question = new Question('Please enter the username of the service:');
            $question->setValidator(function ($username) {
                if (empty($username)) {
                    throw new \Exception('Username can not be empty');
                }

                return $username;
            });
            $questions['username'] = $question;
        }

        if (!$input->getArgument('password')) {
            $question = new Question('Please enter the password of the service:');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception('Password can not be empty');
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }
}
