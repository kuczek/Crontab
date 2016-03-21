<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Console;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Reader\ReaderInterface;
use Hexmedia\Crontab\Reader\SystemReader;
use Hexmedia\Crontab\Reader\ReaderFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CommandAbstract
 *
 * @package Hexmedia\Crontab\Console
 */
abstract class AbstractCommand extends Command
{

    /**
     * @param OutputInterface $output
     * @param Crontab         $crontab
     * @param string|null     $user
     *
     * @return mixed
     */
    abstract public function output(OutputInterface $output, Crontab $crontab, $user = null);

    /**
     *
     */
    protected function configure()
    {
        $this
            ->addOption('machine', 'm', InputOption::VALUE_OPTIONAL, 'Machine name to synchronize')
            ->addOption('dry-run', null, InputOption::VALUE_OPTIONAL, 'Do not write crontab file');

        $this->configureOptionsAndArguments();
        $this->configureName();
    }

    /**
     * @return mixed
     */
    abstract protected function configureName();

    /**
     *
     */
    protected function configureOptionsAndArguments()
    {
        $this
            ->addOption('type', 't', InputOption::VALUE_REQUIRED, 'Type of parsed file, if not given system will guess')
            ->addArgument('configuration-file', InputArgument::REQUIRED, 'Configuration file')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of project');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $crontab = new Crontab(null, $name);

        $systemReader = new SystemReader(null, $crontab);

        $systemReader->read();

        $configuration = $this->prepareConfiguration($input);
        $configuration['crontab'] = $crontab;

//        $this->readConfigurationCrontab($configuration);

        //Trzeba tutaj jakoś zabstractować czytanie.

        /** @var ReaderInterface $reader */
        $reader = ReaderFactory::create($configuration);

        try {
            $crontab = $reader->read();
        } catch (ParsingException $e) {
            $output->writeln(
                sprintf(
                    "<error>File '%s' does not have --type=%s or has error in formatting.</error>",
                    $configuration['file'],
                    $configuration['type']
                )
            );

            return 1;
        }

        $this->output($output, $crontab, null);
    }

    /**
     * @param InputInterface $input
     *
     * @return array
     */
    protected function prepareConfiguration(InputInterface $input)
    {
        $configuration = array();

        $configuration['type'] = $input->getOption('type');
        $configuration['file'] = $input->getArgument('configuration-file');
        $configuration['name'] = $input->getArgument('name');
        $configuration['machine'] = $input->getOption('machine');

        return $configuration;
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function getProjectName(InputInterface $input)
    {
        return $input->getArgument('name');
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function getConfigurationFile(InputInterface $input)
    {
        return $input->getArgument('configuration-file');
    }
}
