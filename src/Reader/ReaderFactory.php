<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Exception\FactoryException;

/**
 * Class ReaderFactory
 *
 * @package Hexmedia\Crontab
 */
class ReaderFactory
{
    private static $initialized = false;
    private static $readers = array();

    /**
     * @param string|array   $type
     * @param string         $reader
     * @param callback|array $creator
     *
     * @throws FactoryException
     */
    public static function addReader($type, $reader, $creator)
    {
        if (is_array($type)) {
            foreach ($type as $t) {
                static::addReader($t, $reader, $creator);
            }
        } else {
            if (false == class_exists($reader)) {
                throw new FactoryException(
                    sprintf("Class %s was not found and cannot be added as reader.", $reader)
                );
            }

            static::$readers[$type] = array($reader, $creator);
        }
    }

    /**
     * @return array
     */
    public static function getReaders()
    {
        return static::$readers;
    }

    /**
     * @param array $configuration
     *
     * @return ReaderInterface
     * @throws FactoryException
     * @throws \Exception
     */
    public static function create(array $configuration)
    {
        $reader = static::createReader($configuration);

        return $reader;
    }

    /**
     * @param array  $configuration
     * @param string $readerClass
     *
     * @return ReaderInterface
     * @throws FactoryException
     */
    protected static function createStandardReader(array $configuration, $readerClass)
    {
        if (!isset($configuration['file'])) {
            throw new FactoryException(sprintf('File needs to be defined for type %s', $configuration['type']));
        }

        $file = $configuration['file'];
        $machine = self::configurationGetOrDefault($configuration, 'machine', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new $readerClass($file, $crontab, $machine);

        return $reader;
    }

    /**
     * @param array  $configuration
     * @param string $readerClass
     *
     * @return ReaderInterface
     */
    protected static function createSystemReader(array $configuration, $readerClass)
    {
        $user = self::configurationGetOrDefault($configuration, 'user', null);
        $crontab = self::configurationGetOrDefault($configuration, 'crontab', null);

        $reader = new $readerClass($user, $crontab);

        return $reader;
    }

    /**
     * Initializing readers if are not initialized
     */
    private static function initializeIfNot()
    {
        if (false === static::$initialized) {
            static::initialize();

        }
    }

    /**
     * Initializing default readers
     */
    private static function initialize()
    {
        static::addReader(
            'ini',
            '\Hexmedia\Crontab\Reader\IniReader',
            array(__CLASS__, 'createStandardReader')
        );
        static::addReader(
            'json',
            '\Hexmedia\Crontab\Reader\JsonReader',
            array(__CLASS__, 'createStandardReader')
        );
        static::addReader(
            'unix',
            '\Hexmedia\Crontab\Reader\UnixSystemReader',
            array(__CLASS__, 'createSystemReader')
        );
        static::addReader(
            'xml',
            '\Hexmedia\Crontab\Reader\XmlReader',
            array(__CLASS__, 'createStandardReader')
        );
        static::addReader(
            array('yaml', 'yml'),
            '\Hexmedia\Crontab\Reader\YamlReader',
            array(__CLASS__, 'createStandardReader')
        );
    }

    /**
     * @param $type
     *
     * @return array|null
     */
    private static function getReaderForType($type)
    {
        if (isset(static::$readers[$type])) {
            return static::$readers[$type];
        }

        return null;
    }

    /**
     * @param array $configuration
     *
     * @return ReaderInterface
     * @throws FactoryException
     */
    private static function createReader(array $configuration)
    {
        static::initializeIfNot();

        if (!isset($configuration['type'])) {
            throw new FactoryException('No type defined, you need to define type to create correct reader.');
        }

        $reader = static::getReaderForType($configuration['type']);

        if (null === $reader) {
            throw new FactoryException(sprintf("Unknown type '%s'", $configuration['type']));
        }

        $readerClass = $reader[0];
        $readerCall = $reader[1];

        if (is_array($readerCall)) {
            return call_user_func($readerCall, $configuration, $readerClass);
        } elseif (is_callable($readerCall)) {
            return $readerCall($configuration, $readerClass);
        }

        throw new FactoryException(sprintf("Cannot initialize reader for type %s", $configuration['type']));
    }


    /**
     * @param array $configuration
     * @param mixed $index
     * @param mixed $default
     *
     * @return mixed
     */
    private static function configurationGetOrDefault($configuration, $index, $default)
    {
        return isset($configuration[$index]) ? $configuration[$index] : $default;
    }
}
