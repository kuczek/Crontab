<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 13:48
 */

namespace Hexmedia\Crontab;


use Hexmedia\Crontab\Reader\IniReader;
use Hexmedia\Crontab\Reader\JsonReader;
use Hexmedia\Crontab\Reader\ReaderInterface;
use Hexmedia\Crontab\Reader\UnixReader;
use Hexmedia\Crontab\Reader\XmlReader;
use Hexmedia\Crontab\Reader\YamlReader;
use Hexmedia\Crontab\Exception\FactoryException;

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
        if (!isset($configuration['type'])) {
            throw new FactoryException("No type defined, cannot use.");
        }

        switch ($configuration['type']) {
            case "json":
                return self::createJson($configuration);
                break;
            case "yaml":
                return self::createYaml($configuration);
                break;
            case "ini":
                return self::createIni($configuration);
                break;
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
     * @return JsonReader
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

        $reader = new JsonReader($file, $crontab, $machine);

        return $reader;
    }

    /**
     * @param array $configuration
     * @return YamlReader
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

        $reader = new YamlReader($file, $crontab, $machine);

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

        $reader = new IniReader($file, $crontab, $machine);

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

        $reader = new XmlReader($file, $crontab, $machine);

        return $reader;
    }


    private static function createUnix($configuration)
    {
        $user = self::configurationGetOrDefault($configuration, 'user', null);
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new UnixReader($user, $crontab, $machine);

        return $reader;
    }

    private static function configurationGetOrDefault($configuration, $index, $default)
    {
        return isset($configuration[$index]) ? $configuration[$index] : $default;
    }
}
