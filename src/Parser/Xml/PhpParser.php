<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Xml;

use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Parser\AbstractParser;

/**
 * Class PhpParser
 *
 * @package Hexmedia\Crontab\Parser\Xml
 */
class PhpParser extends AbstractParser
{

    /**
     * @return array
     *
     * @throws ParsingException
     */
    public function parse()
    {
        try {
            $xml = new \SimpleXMLElement($this->getContent());
        } catch (\Exception $e) {
            throw new ParsingException("Cannot parse this file: " . $e->getMessage());
        }

        $parsed = $this->convertToArray($xml);

        return $parsed;
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return true; //This is supported in php
    }

    /**
     * @param \SimpleXMLElement $xml
     *
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
     *
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
        $taskArray['machine'] = (string) $task->machine;

        if ((string) $task->comment) {
            $taskArray['comment'] = (string) $task->comment;
        }

        if ((string) $task->logFile) {
            $taskArray['log_file'] = (string) $task->logFile;
        }

        if ($task->variables) {
            $taskArray['variables'] = $this->parseVariables($task->variables->variable);
        }

        return $taskArray;
    }

    /**
     * @param \SimpleXMLElement[] $variables
     *
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
