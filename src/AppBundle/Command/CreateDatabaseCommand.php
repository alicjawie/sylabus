<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of CreateDatabaseCommand.
 *
 * @author Paweł Winiecki <pawel.winiecki@gmail.com>
 */
class CreateDatabaseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('syllabus:database:create')
            ->setDescription('Create Syllabus')
        ;
    }

    protected function execute(InputInterface $mainInput, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');

        $arguments = array(
            'command' => 'doctrine:database:drop',
            '--if-exists' => true,
            '--force' => true,
        );

        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:database:create');

        $arguments = array(
            'command' => 'doctrine:database:create',
        );

        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:schema:update');

        $arguments = array(
            'command' => 'doctrine:schema:update',
            '--force' => true,
        );

        $input = new ArrayInput($arguments);
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:fixtures:load');

        $arguments = array(
            'command' => 'doctrine:fixtures:load',
            '--fixtures' => ['src/AppBundle/DataFixtures/ORM/Test/', 'src/AppBundle/DataFixtures/ORM/Prod/'],
        );

        $input = new ArrayInput($arguments);
        $returnCode = $command->run($input, $output);

        $output->writeln('Database create and filled.');
        $output->writeln($returnCode);
    }
}
