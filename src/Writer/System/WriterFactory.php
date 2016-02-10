<?php

namespace Hexmedia\Crontab\Writer\System;

use Hexmedia\Crontab\Exception\WriterNotExistsException;

class WriterFactory
{
    /**
     * @var array
     */
    private static $writers = array('Hexmedia\Crontab\Writer\System\UnixWriter');

    /**
     * @return WriterInterface|null
     */
    public static function create()
    {
        foreach (self::getWriters() as $writer) {
            if (true === call_user_func("$writer::isSupported")) {
                return new $writer();
            }
        }

        return null;
    }

    /**
     * @param string $writer
     *
     * @return bool
     */
    public static function removeWriter($writer)
    {
        $key = array_search($writer, self::$writers);

        if (false !== $key) {
            unset(self::$writers[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param string $writer
     * @throws WriterNotExistsException
     */
    public static function addWriter($writer)
    {
        if (false === class_exists($writer)) {
            throw new WriterNotExistsException(sprintf("Writer with given name %s does not exists.", $writer));
        }

        self::$writers[] = $writer;
    }

    /**
     * @return array
     */
    public static function getWriters()
    {
        return self::$writers;
    }

    /**
     * @param array $writers
     */
    public static function setWriters($writers)
    {
        self::$writers = $writers;
    }
}
