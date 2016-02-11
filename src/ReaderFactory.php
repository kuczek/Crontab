<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab;

use Hexmedia\Crontab\Reader\IniReaderAbstract;
use Hexmedia\Crontab\Reader\JsonReaderAbstract;
use Hexmedia\Crontab\Reader\ReaderInterface;
use Hexmedia\Crontab\Reader\UnixSystemReader;
use Hexmedia\Crontab\Reader\XmlReaderAbstract;
use Hexmedia\Crontab\Reader\YamlReaderAbstract;
use Hexmedia\Crontab\Exception\FactoryException;

/**
 * Class ReaderFactory
 * @package Hexmedia\Crontab
 */
class ReaderFactory
{
    /**
     * @param $configuration
     * @return ReaderInterface
     * @throws FactoryException
     * @throws \Exception
     */
    public static function create($configuration)
    {
        //TODO: HERE WE CAN ADD TYPE DETECTOR ON FILE NAME
        if (!isset($configuration['type'])) {
            throw new FactoryException("No type defined, cannot use.");
        }

        switch ($configuration['type']) {
            case "json":
                return self::createJson($configuration);
            case "yaml":
                return self::createYaml($configuration);
            case "ini":
                return self::createIni($configuration);
            case "xml":
                return self::createXml($configuration);
            case 'unix':
                return self::createUnix($configuration);
            default:
                throw new FactoryException(sprintf("Unknown type '%s'", $configuration['type']));
        }
    }

    /**
     * @param array $configuration
     * @return JsonReaderAbstract
     * @throws FactoryException
     */
    private static function createJson(array $configuration)
    {
        if (!isset($configuration['file'])) {
            throw new FactoryException("File needs to be defined for type json");
        }

        $file = $configuration['file'];
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new JsonReaderAbstract($file, $crontab, $machine);

        return $reader;
    }

    /**
     * @param array $configuration
     * @return YamlReaderAbstract
     * @throws FactoryException
     */
    private static function createYaml(array $configuration)
    {
        if (!isset($configuration['file'])) {
            throw new FactoryException("File needs to be defined for type yaml");
        }

        $file = $configuration['file'];
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new YamlReaderAbstract($file, $crontab, $machine);

        return $reader;
    }

    private static function createIni($configuration)
    {
        if (!isset($configuration['file'])) {
            throw new FactoryException("File needs to be defined for type yaml");
        }

        $file = $configuration['file'];
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new IniReaderAbstract($file, $crontab, $machine);

        return $reader;
    }

    private static function createXml($configuration)
    {
        if (!isset($configuration['file'])) {
            throw new FactoryException("File needs to be defined for type yaml");
        }

        $file = $configuration['file'];
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new XmlReaderAbstract($file, $crontab, $machine);

        return $reader;
    }

    //TODO: FIXME
    private static function createUnix($configuration)
    {
        $user = self::configurationGetOrDefault($configuration, 'user', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new UnixSystemReader($user, $crontab);

        return $reader;
    }

    private static function configurationGetOrDefault($configuration, $index, $default)
    {
        return isset($configuration[$index]) ? $configuration[$index] : $default;
    }
}
