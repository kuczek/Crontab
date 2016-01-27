<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 12:31
 */

namespace Hexmedia\Crontab\Reader;


use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;
use Hexmedia\Crontab\Exception\CrontabException;

abstract class ArrayReader implements ReaderInterface
{
    /**
     * @var Crontab
     */
    private $crontab;

    /**
     * @var null
     */
    private $machine = null;

    /**
     * ArrayReader constructor.
     * @param Crontab|null $crontab
     * @param null $machine;
     */
    public function __construct(Crontab $crontab = null, $machine = null)
    {
        $this->crontab = ($crontab ?: new Crontab());
        $this->machine = $machine;
    }

    protected function readArray(array $array)
    {
        foreach ($array as $name => $task) {
            if (true === $this->checkIfForThisMachine($task['machine'])) {
                $task = $this->createTaskFromConfig($name, $task);

                $this->crontab->addTask($task);
            }
        }

        return $this->crontab;
    }

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

    private function checkIfForThisMachine($machine)
    {
        if (null === $this->machine) {
            return true;
        }

        $pattern = str_replace(array("*", "?"), array(".*", "."), $machine);

        if (preg_match(sprintf("/%s/", $pattern), $this->machine, $matches)) {
            return true;
        }

        return false;
    }
}
