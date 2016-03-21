<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\System;

use Hexmedia\Crontab\Exception\SystemOperationException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class Unix
 *
 * @package Hexmedia\Crontab\System
 */
class Unix
{
    /**
     * @var string|null
     */
    private static $temporaryDir = null;

    /**
     * @var ProcessBuilder
     */
    private static $processBuilder = null;

    /**
     * @var array
     */
    private static $unixes = array('Linux', 'FreeBSD', 'OsX');

    /**
     * @param ProcessBuilder|null $processBuilder
     */
    public static function setProcessBuilder(ProcessBuilder $processBuilder = null)
    {
        self::$processBuilder = $processBuilder;
    }

    /**
     * @return ProcessBuilder
     */
    public static function getProcessBuilder()
    {
        if (null === self::$processBuilder) {
            self::$processBuilder = new ProcessBuilder();
        }

        return self::$processBuilder;
    }

    /**
     * @param null|string $user
     *
     * @return string
     * @throws SystemOperationException
     */
    public static function get($user = null)
    {
        $processArgs = array('-l');

        if (null !== $user) {
            $processArgs[] = '-u';
            $processArgs[] = $user;
        }

        $process = self::getProcessBuilder()
            ->setPrefix('crontab')
            ->setArguments($processArgs)
            ->getProcess();

        $process->run();

        if ($process->getErrorOutput()) {
            if (false === strpos($process->getErrorOutput(), 'no crontab for')) {
                throw new SystemOperationException(sprintf('Executing error: %s', trim($process->getErrorOutput())));
            }

            return false;
        }

        return $process->getOutput();
    }

    /**
     * @param string      $content
     * @param string|null $user
     *
     * @return bool
     * @throws SystemOperationException
     */
    public static function save($content, $user = null)
    {
        $temporaryFile = self::getTemporaryDir() . '/' . md5(rand(0, 10000)) . '.cron';

        $fileHandler = fopen($temporaryFile, 'w');
        flock($fileHandler, LOCK_EX);
        fwrite($fileHandler, $content);
        flock($fileHandler, LOCK_UN);
        fclose($fileHandler);

        $processArgs = array();

        if (null !== $user) {
            $processArgs[] = '-u';
            $processArgs[] = $user;
        }

        $processArgs[] = $temporaryFile;

        $process = self::getProcessBuilder()
            ->setPrefix('crontab')
            ->setArguments($processArgs)
            ->getProcess();

        $process->run();

        if ($process->getErrorOutput()) {
            throw new SystemOperationException(sprintf('Executing error: %s', trim($process->getErrorOutput())));
        }

        if ($process->getOutput()) {
            throw new SystemOperationException(sprintf('Unexpected output: %s', trim($process->getOutput())));
        }

        return true;
    }

    /**
     * @param string|null $user
     *
     * @return bool
     * @throws SystemOperationException
     */
    public static function clear($user = null)
    {
        $processArgs = array();

        if (null !== $user) {
            $processArgs[] = '-u';
            $processArgs[] = $user;
        }

        $processArgs[] = '-r';

        $process = self::getProcessBuilder()
            ->setPrefix('crontab')
            ->setArguments($processArgs)
            ->getProcess();

        $process->run();

        if ($process->getErrorOutput()) {
            if (false === strpos($process->getErrorOutput(), 'no crontab for')) {
                throw new SystemOperationException(sprintf('Executing error: %s', trim($process->getErrorOutput())));
            }

            return true; //It means that it's clear so true should be returned.
        }

        if ($process->getOutput()) {
            throw new SystemOperationException(sprintf('Unexpected output: %s', trim($process->getOutput())));
        }

        return true;
    }

    /**
     * @param null $user
     *
     * @return bool
     * @throws SystemOperationException
     */
    public static function isSetUp($user = null)
    {
        return false !== self::get($user);
    }

    /**
     * @return string
     */
    public static function getTemporaryDir()
    {
        return self::$temporaryDir ?: sys_get_temp_dir();
    }

    /**
     * @param string $temporaryDirectory
     */
    public static function setTemporaryDir($temporaryDirectory)
    {
        self::$temporaryDir = $temporaryDirectory;
    }

    /**
     * @param string|null $osName Default: PHP_OS
     *
     * @return bool
     */
    public static function isUnix($osName = null)
    {
        if (null === $osName) {
            $osName = PHP_OS;
        }

        return in_array($osName, self::$unixes);
    }

    /**
     * @return array
     */
    public static function getUnixList()
    {
        return self::$unixes;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function addUnix($name)
    {
        if (false === in_array($name, self::$unixes)) {
            self::$unixes[] = $name;

            return true;
        }

        return false;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function removeUnix($name)
    {
        $key = array_search($name, self::$unixes);

        if (false !== $key) {
            unset(self::$unixes[$key]);

            return true;
        }

        return false;
    }
}
