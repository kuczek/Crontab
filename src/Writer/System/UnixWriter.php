<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Writer\System;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\System\Unix;
use Hexmedia\Crontab\Task;

/**
 * Class UnixWriter
 * @package Hexmedia\Crontab\Writer\System
 */
class UnixWriter implements WriterInterface
{
    /**
     * @param Crontab $crontab
     * @return string
     */
    public function write(Crontab $crontab)
    {
        $content = $this->prepareContent($crontab);

        return $this->saveCrontab($content);
    }

    /**
     * @param Crontab $crontab
     * @return string
     */
    public function getContent(Crontab $crontab)
    {
        $content = $this->prepareContent($crontab);

        return $content;
    }

    /**
     * @return bool
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public static function isSupported()
    {
        return Unix::isUnix();
    }

    /**
     * @param string $content
     *
     * @return bool
     */
    protected function saveCrontab($content)
    {
        str_replace(2, 1, $content);

        return true;
    }

    private function prepareContent(Crontab $crontab)
    {
        $content = "#WARNING!!!\n";
        $content .= '#This crontab file it at least partialy managed by Crontab by Hexmedia, please check all ' . "restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md\n";
        $content .= "#EOT\n\n";

        foreach ($crontab->getNotManagedTasks() as $task) {
            $content .= "\n" . $this->prepareTask($task, $crontab);
        }

        $content .= sprintf("\n\n# ------------ CURRENTLY MANAGED by %s --------------\n", $crontab->getName());

        /** @var Task $task */
        foreach ($crontab->getManagedTasks() as $task) {
            $content .= "\n" . $this->prepareTask($task, $crontab);
        }

        $content .= "\n";

        return $content;
    }

    /**
     * @param string $comment
     *
     * @return string
     */
    private function prepareComment($comment)
    {
        $exp = explode("\n", $comment);
        $exp = array_map(function ($com) {
            return rtrim($com);
        }, $exp);

        return '#' . trim(implode("\n#", $exp)) . "\n";
    }

    /**
     * @param Task $task
     * @param string $crontabName
     * @return string
     */
    private function prepareTaskNameLine(Task $task, $crontabName)
    {
        return sprintf(
            "DO NOT MODIFY! This task is managed by Crontab library by Hexmedia %s\n",
            $this->prepareTaskHash($task->getName(), $crontabName)
        );
    }

    /**
     * @param string $taskName
     * @param string $crontabName
     *
     * @return string
     */
    private function prepareTaskHash($taskName, $crontabName)
    {
        return substr(md5($crontabName), 0, 10) . substr(md5($taskName), 11);
    }

    /**
     * @param Task $task
     * @return string
     */
    private function prepareTask(Task $task, Crontab $crontab)
    {
        $log = $task->getLogFile() ? '> ' . $task->getLogFile() : '';

        if ($task->isNotManaged()) {
            $comment = $task->getBeforeComment();
        } else {
            $comment = $this->prepareTaskNameLine($task, $crontab->getName()) . $task->getBeforeComment();
        }

        $comment = $this->prepareComment($comment);

        $variables = '';
        if ($task->getVariables() instanceof \Iterator) {
            foreach ($task->getVariables() as $name => $value) {
                $variables .= sprintf("%s=%s\n", $name, $value);
            }
        }

        return sprintf(
            '%s%s%s %s %s %s %s       %s %s',
            $comment,
            $variables,
            $task->getMinute(),
            $task->getHour(),
            $task->getDayOfMonth(),
            $task->getMonth(),
            $task->getDayOfWeek(),
            $task->getCommand(),
            $log
        );
    }
}
