<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Exception\ClassNotExistsException;
use Hexmedia\Crontab\Exception\NotReaderFoundForOSException;

/**
 * Class SystemReader
 *
 * @package Hexmedia\Crontab\Reader
 */
class SystemReader implements ReaderInterface
{
    private $readers = array(
        '\\Hexmedia\\Crontab\\Reader\\UnixSystemReader',
    );

    /**
     * @var string
     */
    private $user;

    /**
     * @var Crontab
     */
    private $crontab;

    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * SystemReader constructor.
     *
     * @param string       $user
     * @param Crontab|null $crontab
     */
    public function __construct($user, Crontab $crontab = null)
    {
        $this->user = $user;
        $this->crontab = $crontab;

        $this->reader = $this->getSystemReader();
    }

    /**
     * @return Crontab
     */
    public function read()
    {
        return $this->reader->read();
    }

    /**
     * @return array
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * @param string $reader
     *
     * @return $this ;
     * @throws ClassNotExistsException
     */
    public function addReader($reader)
    {
        $reader = $this->fixReaderName($reader);

        if (false === class_exists($reader)) {
            throw new ClassNotExistsException(
                sprintf("Class %s does not exists. Cannot be added as Reader.", $reader)
            );
        }

        if (false === in_array($reader, $this->readers)) {
            $this->readers[] = $reader;

            $this->readers = array_values($this->readers); //FIXME: Why this is needed?
        }

        return $this;
    }

    /**
     * @param string $reader
     *
     * @return $this;
     */
    public function removeReader($reader)
    {
        $key = array_search($this->fixReaderName($reader), $this->readers);

        if (false !== $key) {
            unset($this->readers[$key]);
        }

        return $this;
    }

    /**
     * @return ReaderInterface
     * @throws NotReaderFoundForOSException
     */
    private function getSystemReader()
    {
        foreach ($this->readers as $reader) {
            if (false !== call_user_func($reader . '::isSupported')) {
                return new $reader($this->user, $this->crontab);
            }
        }

        throw new NotReaderFoundForOSException(sprintf("There is no reader for your operating system '%s'", PHP_OS));
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function fixReaderName($name)
    {
        return '\\' . trim($name, '\\');
    }
}
