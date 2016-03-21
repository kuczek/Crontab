<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Writer\System;

use dev\Hexmedia\Crontab\PhpSpec\SystemAwareObjectBehavior;
use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\System\Unix;
use Hexmedia\Crontab\Task;
use Hexmedia\Crontab\Variables;
use Hexmedia\Symfony\FakeProcess\FakeProcessBuilder;
use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;

class UnixWriterSpec extends SystemAwareObjectBehavior
{
    private $defaultContent = <<<CONTENT
#WARNING!!!
#This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
#EOT


#This is some comment with
#two lines
*/10 * * * *       test > some_log_file.log
#This is some comment with
#two lines
*/10 * * * *       test > some_log_file.log

# ------------ CURRENTLY MANAGED by TestAopTest --------------

#DO NOT MODIFY! This task is managed by Crontab library by Hexmedia bb83a7fd849c0ab6ec0cfb38d3db6a2
#This is some comment with
#two lines
*/10 * * * *       test > some_log_file.log
#DO NOT MODIFY! This task is managed by Crontab library by Hexmedia bb83a7fd849c0ab6ec0cfb38d3db6a2
#This is some comment with
#two lines
*/10 * * * *       test > some_log_file.log

CONTENT;

    private function prepareTask(&$task, $variables, $notManaged = false, $comment = true)
    {
        $task->getCommand()->willReturn("test");
        $task->getMonth()->willReturn("*");
        $task->getDayOfMonth()->willReturn("*");
        $task->getDayOfWeek()->willReturn("*");
        $task->getHour()->willReturn("*");
        $task->getMinute()->willReturn("*/10");
        $task->getLogFile()->willReturn("some_log_file.log");
        $task->getBeforeComment()->willReturn($comment ? "This is some comment with \ntwo lines" : '');
        $task->isNotManaged()->willReturn($notManaged);
        $task->getVariables()->willReturn($variables);
        $task->getName()->willReturn("synchronize1");
    }

    function let(Crontab $crontab, Task $nmTask1, Task $nmTask2, Task $task1, Task $task2, Variables $variables1)
    {
        $this->isSystemSupported();
        
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
        $this->shouldHaveType('Hexmedia\Crontab\Writer\System\UnixWriter');
        $this->shouldImplement('Hexmedia\Crontab\Writer\System\WriterInterface');
    }

    function it_is_able_to_get_content($crontab)
    {
        $this
            ->getContent($crontab)
            ->shouldReturn($this->defaultContent);
    }

    function it_has_support_for_variables(Task $task3, Variables $variables3, Crontab $crontab2)
    {
        $this->prepareTask($task3, $variables3);

        $variables3->current()->willReturn('value');
        $variables3->key()->willReturn('key');
        $variables3->rewind()->shouldBeCalled();
        $variables3->valid()->willReturn(true, false);
        $variables3->next()->shouldBeCalled();

        $crontab2->getName()->willReturn("TestAopTest");

        $crontab2->getManagedTasks()->willReturn(array($task3));
        $crontab2->getNotManagedTasks()->willReturn(array());

        $this
            ->getContent($crontab2)
            ->shouldReturn(
                <<<CONTENT
#WARNING!!!
#This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
#EOT



# ------------ CURRENTLY MANAGED by TestAopTest --------------

#DO NOT MODIFY! This task is managed by Crontab library by Hexmedia bb83a7fd849c0ab6ec0cfb38d3db6a2
#This is some comment with
#two lines
key=value
*/10 * * * *       test > some_log_file.log

CONTENT
            );
    }

    function it_works_with_crons_without_comments(Task $taskWC, Variables $variablesWC, Crontab $crontabWC)
    {
        $this->prepareTask($taskWC, $variablesWC, true, false);

        $variablesWC->current()->willReturn('value');
        $variablesWC->key()->willReturn('key');
        $variablesWC->rewind()->shouldBeCalled();
        $variablesWC->valid()->willReturn(true, false);
        $variablesWC->next()->shouldBeCalled();

        $crontabWC->getName()->willReturn("TestAopTest");

        $crontabWC->getManagedTasks()->willReturn(array($taskWC));
        $crontabWC->getNotManagedTasks()->willReturn(array());

//        echo($this->getContent($crontabWC)->getWrappedObject());
//        die();

        $this
            ->getContent($crontabWC)
            ->shouldReturn(
                <<<CONTENT
#WARNING!!!
#This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
#EOT



# ------------ CURRENTLY MANAGED by TestAopTest --------------

key=value
*/10 * * * *       test > some_log_file.log

CONTENT
            );
    }

    function it_allows_to_write($crontab)
    {
        $processBuilder = new FakeProcessBuilder();

        $shouldBe = $this->defaultContent;

        $processBuilder->addCommand(
            "'crontab' '(/var)?/tmp/.*'",
            function ($command) use ($shouldBe) {
                if (preg_match("#'crontab' '((/var)?/tmp/.*)'#", $command, $matches)) {
                    $content = file_get_contents($matches[1]);

                    if ($content !== $shouldBe) {
                        throw new FailureException("Content in not correct");
                    }
                }
            },
            1
        );

        Unix::setProcessBuilder($processBuilder);

        $this->write($crontab)->shouldReturn(true);

        Unix::setProcessBuilder(null);
    }
}
