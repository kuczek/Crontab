<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab;

/**
 * Class Task
 *
 * @package Hexmedia\Crontab
 */
class Task
{
    /**
     * @var array
     */
    private $variables = array();

    /**
     * @var string
     */
    private $minute = '*';

    /**
     * @var string
     */
    private $hour = '*';

    /**
     * @var string
     */
    private $dayOfMonth = '*';

    /**
     * @var string
     */
    private $month = '*';

    /**
     * @var string
     */
    private $dayOfWeek = '*';

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
     * @return Variables[]
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param Variables $variables
     *
     * @return $this
     */
    public function setVariables(Variables $variables)
    {
        $this->variables = $variables;

        return $this;
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
        $this->notManaged = true === $notManaged;

        return $this;
    }

    /**
     * @param string $name
     */
    public function setMd5Name($name)
    {
        $this->setName(substr(md5($name), 10));
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
}
