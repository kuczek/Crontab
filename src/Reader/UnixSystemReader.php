<?php

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

class UnixSystemReader extends UnixReader
{

    /**
     * @var string
     */
    private $user;

    public function __construct($user, Crontab $crontab = null)
    {
        $this->user = $user;

        parent::__construct($crontab);
    }

    public static function isSupported()
    {
        return in_array(PHP_OS, array('Linux', "FreeBSD"));
    }

    /**
     * @return string
     */
    protected function getContent()
    {
        $output = array();

        $result = exec(sprintf("crontab -l %s", ($this->user ? "-u $this->user" : "")), $output);

        if ($result) {
            return implode("\n", $output);
        }
    }
}
