<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Exception\NotReaderFoundForOSException;

/**
 * Class SystemReader
 * @package Hexmedia\Crontab\Reader
 */
class SystemReader implements ReaderInterface
{
    private $readers = array(
        '\\Hexmedia\\Crontab\\Reader\\UnixSystemReader'
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
     * @return array
     */
    public function getReaders()
    {
        return $this->readers;
    }

    /**
     * @param string $reader
     *
     * @return $this;
     */
    public function addReader($reader)
    {
        $this->readers[] = $reader;

        return $this;
    }

    /**
     * @param string $reader
     *
     * @return $this;
     */
    public function removeReader($reader)
    {
        $key = array_search($reader, $this->readers);

        if (false !== $key) {
            unset($this->readers[$key]);
        }

        return $this;
    }
}
