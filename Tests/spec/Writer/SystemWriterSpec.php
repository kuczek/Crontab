<?php

namespace spec\Hexmedia\Crontab\Writer;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\System\Unix;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SystemWriterSpec extends ObjectBehavior
{
    private function prepareTask(&$task, $variables, $notManaged = false)
    {
        $task->getCommand()->willReturn("test");
        $task->getMonth()->willReturn("*");
        $task->getDayOfMonth()->willReturn("*");
        $task->getDayOfWeek()->willReturn("*");
        $task->getHour()->willReturn("*");
        $task->getMinute()->willReturn("*/10");
        $task->getLogFile()->willReturn("some_log_file.log");
        $task->getBeforeComment()->willReturn("This is some comment with \n two lines");
        $task->isNotManaged()->willReturn($notManaged);
        $task->getVariables()->willReturn($variables);
        $task->getName()->willReturn("synchronize1");
    }

    function let(Crontab $crontab, Task $nmTask1, Task $nmTask2, Task $task1, Task $task2, Variables $variables1)
    {
        $this->prepareTask($task1, $variables1);
        $this->prepareTask($task2, $variables1);

        $this->prepareTask($nmTask1, $variables1, true);
        $this->prepareTask($nmTask2, $variables1, true);

        $crontab->getName()->willReturn("TestAopTest");

        $crontab->getManagedTasks()->willReturn(array($task1, $task2));
        $crontab->getNotManagedTasks()->willReturn(array($nmTask1, $nmTask2));
    }

    function it_is_initializable()
    {
        if (Unix::isUnix()) { //Currently this will work only on *nix
            $this->shouldHaveType('Hexmedia\Crontab\Writer\SystemWriter');
        }
    }

    function it_is_properly_writing($crontab)
    {
        $this->write($crontab)->shouldReturn(true);
    }

    function it_is_properly_preparing_content($crontab)
    {
        $this->getContent($crontab)->shouldContain("test");//shouldReturn($shouldBe);
    }
}
