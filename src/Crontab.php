<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab;

use Hexmedia\Crontab\Exception\NotManagedException;

/**
 * Class Crontab
 * @package Hexmedia\Crontab
 */
class Crontab
{
    /**
     * @var string Unique hash for this crontab list
     */
    private $name;

    /**
     * @var Task[]
     */
    private $managedTasks = array();

    /**
     * @var Task[]
     */
    private $notManagedTasks = array();

    /**
     * @var string|null
     */
    private $user = null;


    /**
     * @param string|null $user
     * @param string|null $name
     */
    public function __construct($user = null, $name = null)
    {
        $this->user = $user;
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Task $task
     *
     * @return $this
     */
    public function addTask(Task $task)
    {
        if ($task->isNotManaged()) {
            $this->notManagedTasks[] = $task;
        } else {
            $this->managedTasks[$task->getName()] = $task;
        }

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     * @throws NotManagedException
     */
    public function removeTask(Task $task)
    {
        if ($task->isNotManaged()) {
            throw new NotManagedException('This task is not managed by this application so you cannot remove it!');
        }

        foreach ($this->managedTasks as $key => $taskIteration) {
            if ($taskIteration->getName() === $task->getName()) {
                unset($this->managedTasks[$key]);
            }
        }

        return $this;
    }

    /**
     * @return \Hexmedia\Crontab\Task[]
     */
    public function getManagedTasks()
    {
        return $this->managedTasks;
    }

    /**
     * @return \Hexmedia\Crontab\Task[]
     */
    public function getNotManagedTasks()
    {
        return $this->notManagedTasks;
    }

    /**
     * @return $this
     */
    public function clearManagedTasks()
    {
        $this->managedTasks = array();

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUser()
    {
        return $this->user;
    }
}
