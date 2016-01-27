<?php

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;
use Hexmedia\Crontab\Exception\CrontabException;
use Hexmedia\Crontab\Exception\ParseException;

/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-22
 * Time: 14:21
 *
 * TODO: This class needs to be rewritten, there was too many new requirements identified during development
 */
class SystemReader implements ReaderInterface
{
    /**
     * @var Crontab
     */
    private $crontab;

    /**
     * @var string
     */
    private $user = null;

    /**
     * SystemReader constructor.
     * @param Crontab|null $crontab
     * @param array $configuration
     */
    public function __construct(Crontab $crontab = null, array $configuration = array())
    {
        if (isset($configuration['user'])) {
            $this->user = $configuration['user'];
        }

        $this->crontab = ($crontab ?: new Crontab($this->user));
    }

    /**
     * @return Crontab
     * @throws CrontabException
     *
     * TODO: Move this to __construct
     */
    public function read()
    {
        $outputArray = $this->getSystemCrontab($this->user);

        $beforeComment = '';
        $variables = array();
        foreach ($outputArray as $lineNumber => $line) {
            if (strlen($line) == 0 || strpos($line, "#") === 0) {
                $beforeComment .= $line . "\n";
                continue;
            }

            if (preg_match("/(?<variable>[A-Z]*)=(?<value>.*)/", $line, $matches)) {
                $variables[$matches['variable']] = $matches['value'];
                continue;
            }

            $task = $this->createTaskFromString($outputArray, $lineNumber, $variables);
            $task->setBeforeComment($beforeComment);
            $beforeComment = '';

            $this->crontab->addTask($task);
            $variables = array();
        }

        return $this->crontab;
    }

    /**
     * @param array $outputArray
     * @param string $lineNumber
     *
     * @param array $variables
     * @return Task
     * @throws ParseException
     */
    private function createTaskFromString($outputArray, $lineNumber, array $variables)
    {
        $name = $this->parseTaskName($outputArray, $lineNumber - 1 - sizeof($variables));

        //Compare hashes

        $task = new Task();

        if (false === $name || substr($name, 0, 10) != substr(md5($this->crontab->getName()), 0, 10)) {
            $task->setNotManaged(true);
        } else {
            $task->setName(substr($name, 10));
        }

        $matches = array();
        $timeRule = '[\*\/[0-9]*';
        $space = '[\t\s]+';

        $rule = sprintf(
            '/(?<minutes>[\*\/[0-9]*)[\t\s]+(?<hours>[\*\/[0-9]*)[\t\s]+(?<dayOfMonth>[\*\/[0-9]*)[\t\s]+' .
            '(?<month>[\*\/[0-9]*)[\t\s]+(?<dayOfWeek>[\*\/[0-9]*)[\t\s]+(?<command>[^>]*)[\t\s]+' .
            '(>>?(?<file>[a-zA-Z0-9\/\-\_:\s\.]*))?/',
            $timeRule,
            $space,
            $timeRule,
            $space,
            $timeRule,
            $space,
            $timeRule,
            $space,
            $timeRule,
            $space,
            $space,
            $space
        );

        if (!preg_match($rule, $outputArray[$lineNumber], $matches)) {
            $error = preg_last_error();

            if (PREG_NO_ERROR !== $error) {
                throw new ParseException(sprintf("Parsing error: \"%d\", more info see %s.", preg_last_error(),
                    'http://php.net/manual/en/function.preg-last-error.php#refsect1-function.preg-last-error-returnvalues'));
            } else {
                throw new ParseException("No matches for preg rule.");
            }

        }

        $task->setMinute($matches['minutes']);
        $task->setHour($matches['hours']);
        $task->setDayOfMonth($matches['dayOfMonth']);
        $task->setDayOfWeek($matches['dayOfWeek']);
        $task->setMonth($matches['month']);
        $task->setCommand($matches['command']);
        $task->setLogFile($matches['file']);
        $task->setVariables(new Variables($variables));

        return $task;
    }

    private function getSystemCrontab($user = null)
    {
        $lastLine = exec(sprintf("crontab %s -l", $user ? "-u $user" : ''), $output);

        if ($lastLine) {
            return $output;
        }
    }

    private function parseTaskName($outputArray, $line)
    {
        if ($line < 0 || !isset($outputArray[$line])) {
            return false;
        }

        $matches = array();

        if (preg_match(sprintf('/%s/', Task::nameString('(?<name>[a-zA-Z0-9_\-]*)')), $outputArray[$line], $matches)) {
            if (sizeof($matches) == 3) {
                return $matches['name'];
            }
        }

        return false;
    }
}
