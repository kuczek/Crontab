<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab;

use Hexmedia\Crontab\Exception\NotManagedException;
use Hexmedia\Crontab\Task;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CrontabSpec
 *
 * @package spec\Hexmedia\Crontab
 *
 * @covers Hexmedia\Crontab\Crontab
 */
class CrontabSpec extends ObjectBehavior
{
    public $name = "aaa";

    function let()
    {
        $this->beConstructedWith(null, $this->name);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Crontab');
    }

    function it_is_possible_to_add_and_remove_managed_task(Task $task)
    {
        $task->isNotManaged()->willReturn(false);
        $task->getName()->willReturn("name");

        $this->addTask($task);

        $this->getManagedTasks()->shouldHaveCount(1);

        $this->removeTask($task);

        $this->getManagedTasks()->shouldHaveCount(0);
    }

    function it_is_possible_to_add_not_managed_task(Task $task)
    {
        $task->isNotManaged()->willReturn(true);
        $task->getName()->willReturn("name");

        $this->addTask($task);

        $this->getNotManagedTasks()->shouldHaveCount(1);
    }

    function it_is_possible_to_clear_tasks(Task $task)
    {
        $task->isNotManaged()->willReturn(false);
        $task->getName()->willReturn("name");

        $this->addTask($task);

        $this->getManagedTasks()->shouldHaveCount(1);

        $this->clearManagedTasks();

        $this->getManagedTasks()->shouldHaveCount(0);
    }

    function it_is_correctly_returing_name()
    {
        $this->getName()->shouldReturn($this->name);
    }

    function it_is_allowing_to_remove_taks(Task $task)
    {
        $task->isNotManaged()->willReturn(false);
        $task->getName()->willReturn("Some Name");
        $this->getManagedTasks()->shouldHaveCount(0);
        $this->addTask($task);
        $this->getManagedTasks()->shouldHaveCount(1);
        $this->removeTask($task)->shouldReturn($this);
        $this->getManagedTasks()->shouldHaveCount(0);
    }

    function it_is_not_allowing_to_remove_non_existing_task(Task $task)
    {
        $task->isNotManaged()->willReturn(false);
        $task->getName()->willReturn("Some Name");
        $this->getManagedTasks()->shouldHaveCount(0);
        $this->removeTask($task)->shouldReturn($this);
        $this->getManagedTasks()->shouldHaveCount(0);
    }

    function it_is_not_allowing_to_remove_not_managed_task(Task $task)
    {
        $task->isNotManaged()->willReturn(true);
        $task->getName()->willReturn("Some Name");
        $this->getNotManagedTasks()->shouldHaveCount(0);
        $this->addTask($task);
        $this->getNotManagedTasks()->shouldHaveCount(1);
        $this
            ->shouldThrow(new NotManagedException("This task is not managed by this application so you cannot remove it!"))
            ->duringRemoveTask($task);
    }

    function it_is_returning_user()
    {
        $this->getUser()->shouldReturn(null);
    }
}
