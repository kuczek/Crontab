<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;

/**
 * Class ArrayReaderAbstract
 * @package Hexmedia\Crontab\Reader
 */
abstract class ArrayReaderAbstract implements ReaderInterface
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
     * ArrayReader constructor.
     * @param Crontab|null $crontab
     * @param string|null  $machine
     */
    public function __construct(Crontab $crontab = null, $machine = null)
    {
        $this->crontab = ($crontab ?: new Crontab());
        $this->machine = $machine;
    }

    /**
     * @param array $array
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
     * @return Crontab
     */
    public function read()
    {
        $array = $this->prepareArray();

        return $this->readArray($array);
    }

    /**
     * @return array
     */
    abstract protected function prepareArray();

    /**
     * @param string $name
     * @param array $taskArray
     * @return Task
     */
    private function createTaskFromConfig($name, array $taskArray)
    {
        $task = new Task();

        $task->setMd5Name($name);
        $task->setNotManaged(false);
        $task->setCommand($taskArray['command']);
        $task->setMinute($taskArray['minute']);
        $task->setDayOfMonth($taskArray['day_of_month']);
        $task->setDayOfWeek($taskArray['day_of_week']);
        $task->setMonth($taskArray['month']);
        $task->setLogFile($taskArray['log_file']);
        $task->setVariables(new Variables($taskArray['variables']));

        return $task;
    }

    /**
     * @param string $machine
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
