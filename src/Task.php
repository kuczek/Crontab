<?php
/**
 * @copyright 2015 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab;

class Task
{
    /**
     * @var array
     */
    private $variables = array();

    /**
     * @var null|string
     */
    private $hash = null;
    /**
     * @var string
     */
    private $minute = "*";

    /**
     * @var string
     */
    private $hour = "*";

    /**
     * @var string
     */
    private $dayOfMonth = "*";

    /**
     * @var string
     */
    private $month = "*";

    /**
     * @var string
     */
    private $dayOfWeek = "*";

    /**
     * @var string
     */
    private $command;

    /**
     * @var string
     */
    private $beforeComment;

    /**
     * @var string
     */
    private $logFile;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $notManaged;

    /**
     * @return null|string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param null|string $hash
     *
     * @return $this;
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param Variables $variables
     */
    public function setVariables(Variables $variables)
    {
        $this->variables = $variables;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     *
     * @return $this;
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getDayOfMonth()
    {
        return $this->dayOfMonth;
    }

    /**
     * @param string $dayOfMonth
     *
     * @return $this;
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->dayOfMonth = $dayOfMonth;

        return $this;
    }

    /**
     * @return string
     */
    public function getDayOfWeek()
    {
        return $this->dayOfWeek;
    }

    /**
     * @param string $dayOfWeek
     *
     * @return $this;
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->dayOfWeek = $dayOfWeek;

        return $this;
    }

    /**
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param string $hour
     *
     * @return $this;
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return $this->logFile;
    }

    /**
     * @param string $logFile
     *
     * @return $this;
     */
    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param string $minute
     *
     * @return $this;
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;

        return $this;
    }

    /**
     * @return string
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param string $month
     *
     * @return $this;
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this;
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNotManaged()
    {
        return $this->notManaged;
    }

    /**
     * @param boolean $notManaged
     *
     * @return $this;
     */
    public function setNotManaged($notManaged)
    {
        $this->notManaged = $notManaged;

        return $this;
    }

    /**
     * @return string
     */
    public function getBeforeComment()
    {
        return $this->beforeComment;
    }

    /**
     * @param string $beforeComment
     *
     * @return $this;
     */
    public function setBeforeComment($beforeComment)
    {
        $this->beforeComment = $beforeComment;

        return $this;
    }

    /**
     * @return string
     *
     * TODO: przyjrzeć się temu pomysłowi, bo na ten moment z niego zrezygnowałem, nie wiem dlaczego on tu był
     */
//    public function generateHash()
//    {
//        $fields = array(
//            'minute',
//            'hour',
//            'month',
//            'dayOfMonth',
//            'dayOfWeek',
//            'command',
//            'logFile'
//        );
//
//        $str = '';
//
//        foreach ($fields as $field) {
//            $fun = 'get' . ucfirst($field);
//
//            $str .= $this->$fun();
//        }
//
//        return md5($str);
//    }

    /**
     * @param $name
     */
    public function setMd5Name($name) {
        $this->setName(substr(md5($name), 10));
    }

    /**
     * @return string
     *
     * TODO: Move this from here.
     */
    public function __toString()
    {
        $log = $this->getLogFile() ? "> " . $this->getLogFile() : '';

        $comment = $this->isNotManaged() ? $this->getBeforeComment() : $this->nameLine();

        $variables = "";
        foreach ($this->getVariables() as $name => $value) {
            $variables .= sprintf("%s=%s\n", $name, $value);
        }

        return sprintf(
            "%s%s%s %s %s %s %s       %s %s",
            $comment,
            $variables,
            $this->getMinute(),
            $this->getHour(),
            $this->getDayOfMonth(),
            $this->getMonth(),
            $this->getDayOfWeek(),
            $this->getCommand(),
            $log
        );
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function nameString($name)
    {
        return sprintf("# Rule below is managed by CrontabLibrary by Hexmedia - Do not modify it!  %s", $name);
    }

    /**
     * @return string
     */
    public function getTaskHash() {
        return substr(md5($this->getHash()), 0, 10) . $this->getName();
    }

    /**
     * @return string
     */
    private function nameLine()
    {
        return self::nameString($this->getTaskHash()) . "\n";
    }
}
