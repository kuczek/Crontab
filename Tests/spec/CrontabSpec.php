<?php

namespace spec\Hexmedia\Crontab;

use Hexmedia\Crontab\Task;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
        $task->setHash($this->name)->shouldBeCalled();
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
        $task->setHash($this->name)->shouldBeCalled();
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
}
