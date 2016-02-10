<?php

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Reader\ReaderInterface;
use Hexmedia\Crontab\Reader\SystemReader;
use Hexmedia\Crontab\ReaderFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->addOption("machine", "m", InputOption::VALUE_OPTIONAL, "Machine name to synchronize")
            ->addOption("user", "u", InputOption::VALUE_OPTIONAL, "Username for synchronization (crontab -u)")
            ->addOption("type", "t", InputOption::VALUE_REQUIRED, "Type of parsed file, if not given system will guess")
            ->addOption("dry-run", null, InputOption::VALUE_OPTIONAL, "Do not write crontab file");

        $this->configureArguments();
        $this->configureName();
    }

    abstract protected function configureName();

    /**
     *
     */
    protected function configureArguments()
    {
        $this
            ->addArgument("configuration-file", InputArgument::REQUIRED, "Configuration file")
            ->addArgument("name", InputArgument::REQUIRED, "Name of project");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument("name");
        $user = $input->getOption("user");

        $crontab = new Crontab($user, $name);

        $systemReader = new SystemReader($user, $crontab);

        $systemReader->read();

        $configuration = $this->prepareConfiguration($input);
        $configuration['crontab'] = $crontab;

        /** @var ReaderInterface $reader */
        $reader = ReaderFactory::create($configuration);

        $crontab = $reader->read();

        $this->output($output, $crontab, $user);
    }

    /**
     * @param OutputInterface $output
     * @param Crontab $crontab
     * @param string|null $user
     * @return mixed
     */
    abstract public function output(OutputInterface $output, Crontab $crontab, $user = null);

    /**
     * @param InputInterface $input
     *
     * @return array
     */
    protected function prepareConfiguration(InputInterface $input)
    {
        $configuration = array();

        $configuration['user'] = $input->getOption('user');
        $configuration['type'] = $input->getOption('type');
        $configuration['file'] = $input->getArgument('configuration-file');
        $configuration['name'] = $input->getArgument('name');
        $configuration['machine'] = $input->getOption('machine');

        return $configuration;
    }
}
