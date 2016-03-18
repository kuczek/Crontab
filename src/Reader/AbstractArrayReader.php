<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;

/**
 * Class ArrayReaderAbstract
 *
 * @package Hexmedia\Crontab\Reader
 */
abstract class AbstractArrayReader implements ReaderInterface
{
    /**
     * @var Crontab
     */
    private $crontab;

    /**
     * @var string|null
     */
    private $machine = null;

    /**
     * @var bool
     */
    private $notManaged = false;

    /**
     * ArrayReader constructor.
     *
     * @param Crontab|null $crontab
     * @param string|null  $machine
     */
    public function __construct(Crontab $crontab = null, $machine = null)
    {
        $this->crontab = ($crontab ?: new Crontab());
        $this->machine = $machine;
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
     */
    public function setNotManaged($notManaged)
    {
        $this->notManaged = $notManaged;
    }

    /**
     * @return Crontab
     */
    public function read()
    {
        $array = $this->prepareArray();

        if (is_array($array)) {
            return $this->readArray($array);
        }

        return $this->crontab;
    }

    /**
     * @param array $array
     *
     * @return Crontab
     */
    protected function readArray(array $array)
    {
        foreach ($array as $name => $task) {
            if (true === $this->checkIfForThisMachine(isset($task['machine']) ? $task['machine'] : null)) {
                $task = $this->createTaskFromConfig($name, $task);

                $this->crontab->addTask($task);
            }
        }

        return $this->crontab;
    }

    /**
     * @return array
     */
    abstract protected function prepareArray();

    /**
     * @param string $name
     * @param array  $taskArray
     *
     * @return Task
     */
    private function createTaskFromConfig($name, array $taskArray)
    {
        $task = new Task();

        $task->setMd5Name($name);
        $task->setNotManaged($this->notManaged);
        $task->setCommand($taskArray['command']);
        $task->setMinute($taskArray['minute']);
        $task->setDayOfMonth($taskArray['day_of_month']);
        $task->setDayOfWeek($taskArray['day_of_week']);
        $task->setMonth($taskArray['month']);

        if (isset($taskArray['variables'])) {
            $task->setVariables(new Variables($taskArray['variables']));
        }

        if (isset($taskArray['log_file'])) {
            $task->setLogFile($taskArray['log_file']);
        }

        return $task;
    }

    /**
     * @param string $machine
     *
     * @return bool
     */
    private function checkIfForThisMachine($machine)
    {
        if (null === $this->machine) {
            return true;
        }

        //It means that it was read from this device, or has no marked device so should be installed on all of them
        if (null === $machine) {
            return true;
        }

        $pattern = str_replace(array('*', '?'), array('.*', '.'), $machine);

        if (preg_match(sprintf('/%s/', $pattern), $this->machine)) {
            return true;
        }

        return false;
    }
}
