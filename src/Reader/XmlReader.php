<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

/**
 * Class XmlReader
 * @package Hexmedia\Crontab\Reader
 */
class XmlReader extends FileReaderAbstract implements ReaderInterface
{
    /**
     * @return array
     */
    protected function parse()
    {
        $xml = new \SimpleXMLElement($this->getContent());

        $parsed = $this->convertToArray($xml);

        return $parsed;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    private function convertToArray($xml)
    {
        $responseArray = array();

        foreach ($xml->task as $task) {
            $responseArray[(string) $task->name] = $this->taskToArray($task);
        }

        return $responseArray;
    }

    /**
     * @param \SimpleXMLElement $task
     * @return array
     */
    private function taskToArray($task)
    {
        $taskArray = array();

        $taskArray['command'] = (string) $task->command;
        $taskArray['month'] = (string) $task->month;
        $taskArray['day_of_month'] = (string) $task->dayOfMonth;
        $taskArray['day_of_week'] = (string) $task->dayOfWeek;
        $taskArray['hour'] = (string) $task->hour;
        $taskArray['minute'] = (string) $task->minute;
        $taskArray['logFile'] = (string) $task->logFile;
        $taskArray['machine'] = (string) $task->machine;
        $taskArray['variables'] = $this->parseVariables($task->variables->variable);

        return $taskArray;
    }

    /**
     * @param \SimpleXMLElement[] $variables
     * @return array
     */
    private function parseVariables($variables)
    {
        $variablesArray = array();

        /** @var \SimpleXMLElement $variable */
        foreach ($variables as $variable) {
            $variablesArray[(string) $variable->attributes()->name] = (string) $variable;
        }

        return $variablesArray;
    }
}
