<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Class UnixSystemReader
 * @package Hexmedia\Crontab\Reader
 */
class UnixSystemReader extends UnixReaderAbstract
{
    /**
     * @var array
     */
    private static $supportedOses = array('Linux', 'FreeBSD');

    /**
     * @var string
     */
    private $user;

    /**
     * UnixSystemReader constructor.
     * @param string       $user
     * @param Crontab|null $crontab
     */
    public function __construct($user, Crontab $crontab = null)
    {
        $this->user = $user;

        parent::__construct($crontab);
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return in_array(PHP_OS, self::$supportedOses);
    }

    /**
     * @return string
     */
    protected function getContent()
    {
        $output = array();

        $result = exec(sprintf('crontab -l %s', ($this->user ? "-u $this->user" : '')), $output);

        if ($result) {
            return implode("\n", $output);
        }
    }

    /**
     * @return array
     */
    public static function getSupportedOses()
    {
        return self::$supportedOses;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function addSupportedOs($name)
    {
        self::$supportedOses[] = $name;

        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function removeSupportedOs($name)
    {
        $key = array_search($name, self::$supportedOses);

        if (false !== $key) {
            unset(self::$supportedOses[$key]);

            return true;
        }

        return false;
    }
}
