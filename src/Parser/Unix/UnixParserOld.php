<?php

namespace Hexmedia\Crontab\Parser\Unix;

class UnixParserOld extends UnixParser
{
    /**
     * @var string
     */
    private $userName;
    /**
     * @var array
     */
    private static $supportedOs = array(
        'Linux',
        'FreeBSD'
    );

    /**
     * UnixParser constructor.
     *
     * @param string $userName
     */
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    /**
     * This function should return the content of crontab compatible file (crontab -l)
     *
     * @return string
     */
    protected function getContent()
    {
        return $this->readFromSystem();
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return in_array(PHP_OS, self::getSupportedOs());
    }

    /**
     * Returns all operating systems supported by this *nix like library
     *
     * @return string[]
     */
    public static function getSupportedOs()
    {
        return self::$supportedOs;
    }

    /**
     * @return string|null
     */
    private function readFromSystem()
    {
        $output = array();

        $result = exec(sprintf("crontab -l %s", ($this->userName ? "-u $this->userName" : "")), $output);

        if ($result) {
            return implode("\n", $output);
        }
    }

    /**
     * @param string $osName
     */
    public function addSupportedOs($osName)
    {
        self::$supportedOs[] = $osName;
    }

    /**
     * @param string $osName
     */
    public function removeSupportedOs($osName)
    {
        $key = array_search($osName, self::$supportedOs);

        unset(self::$supportedOs[$key]);
    }
}
