<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:10
 */

namespace Hexmedia\Crontab\Reader;


class XmlReader extends FileReader implements ReaderInterface
{
    protected function parse()
    {
        $xml = new \SimpleXMLElement($this->getContent());

        $parsed = $this->convertToArray($xml);

        return $parsed;
    }

    private function convertToArray($xml)
    {
        $responseArray = array();

        foreach ($xml->task as $task) {
            $responseArray[(string)$task->name] = $this->taskToArray($task);
        }

        return $responseArray;
    }

    private function taskToArray($task)
    {
        $taskArray = array();

        $taskArray['command'] = (string)$task->command;
        $taskArray['month'] = (string)$task->month;
        $taskArray['day_of_month'] = (string)$task->dayOfMonth;
        $taskArray['day_of_week'] = (string)$task->dayOfWeek;
        $taskArray['hour'] = (string)$task->hour;
        $taskArray['minute'] = (string)$task->minute;
        $taskArray['logFile'] = (string)$task->logFile;
        $taskArray['machine'] = (string)$task->machine;
        $taskArray['variables'] = $this->parseVariables($task->variables);

        return $taskArray;
    }

    private function parseVariables($variables) {
        $variablesArray = array();

        /** @var \SimpleXMLElement $variable */
        foreach ($variables->variable as $variable) {
            $variablesArray[(string)$variable->attributes()->name] = (string)$variable;
        }

        return $variablesArray;
    }
}
