<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace dev\Hexmedia\Crontab\PhpSpec\Parser;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class AbstractParserObjectBehavior
 *
 * @package Hexmedia\CrontabDev\PhpSpec\Parser
 */
abstract class AbstractParserObjectBehavior extends ObjectBehavior
{
    abstract protected function getFileName();

    /**
     * @return array
     */
    public function getMatchers()
    {
        //Fix for php5.3
        $that = $this;

        return array(
            'beProperlyParsed' => function ($subject) use ($that) {
                if (!is_array($subject)) {
                    throw new FailureException("Returned value should be an array!");
                }

                if (sizeof($subject) != 3) {
                    throw new FailureException("Returned array should have 2 elements!");
                }

                if (!isset($subject['command1'])) {
                    throw new FailureException('Index "command1" should be defined.');
                }

                if (!isset($subject['command2'])) {
                    throw new FailureException('Index "command2" should be defined.');
                }

                $that->checkCommand(
                    $subject['command1'],
                    10,
                    './some/command1',
                    '*/13',
                    '*',
                    '*',
                    '*',
                    '*',
                    './logs/some_log1.log',
                    'www*',
                    'this is some comment for this crontab',
                    array('MAILTO' => 'test@test.pl')
                );

                $that->checkCommand(
                    $subject['command2'],
                    9,
                    './some/command2',
                    '*',
                    '*',
                    '*',
                    '*',
                    '*',
                    './logs/some_log2.log',
                    'www103',
                    null,
                    array('MAILTO' => 'test@test.com', 'NO_VALIDATE' => '1')
                );

                $that->checkCommand(
                    $subject['command_without_log_file'],
                    7,
                    './some/command_without_log_file',
                    '*',
                    '*',
                    '*',
                    '*',
                    '*',
                    null,
                    'www103',
                    null,
                    null
                );

                return true;
            },
        );
    }

    /**
     * @return string
     */
    public function getWrongFileName()
    {
        $extension = pathinfo($this->getFileName(), PATHINFO_EXTENSION);

        $mapping = array(
            'ini' => 'yml',
            'yml' => 'json',
            'yaml' => 'json',
            'json' => 'xml',
            'xml' => 'ini',
        );


        return str_replace($extension, $mapping[$extension], $this->getFileName());
    }

    /**
     * @param array  $subject
     * @param string $count
     * @param string $command
     * @param string $minute
     * @param string $hour
     * @param string $dayOfMonth
     * @param string $dayOfWeek
     * @param string $month
     * @param string $logFile
     * @param string $machine
     * @param string $comment
     * @param string $variables
     *
     * @throws FailureException
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function checkCommand(
        array $subject,
        $count,
        $command,
        $minute,
        $hour,
        $dayOfMonth,
        $dayOfWeek,
        $month,
        $logFile,
        $machine,
        $comment,
        $variables
    ) {
        if (sizeof($subject) != $count) {
            throw new FailureException(
                sprintf(
                    "This command array should have %d elements, %d given",
                    $count,
                    sizeof($subject)
                )
            );
        }

        $this->compareAndThrow("Command", $subject['command'], $command);
        $this->compareAndThrow("Minute", $subject['minute'], $minute);
        $this->compareAndThrow('Hour', $subject['hour'], $hour);
        $this->compareAndThrow('Day_of_month', $subject['day_of_month'], $dayOfMonth);
        $this->compareAndThrow('Day_of_week', $subject['day_of_week'], $dayOfWeek);
        $this->compareAndThrow('Month', $subject['month'], $month);
        if (null !== $logFile) {
            $this->compareAndThrow('Log_file', $subject['log_file'], $logFile);
        }
        $this->compareAndThrow('Machine', $subject['machine'], $machine);
        if (isset($subject['comment'])) {
            $this->compareAndThrow('Comment', $subject['comment'], $comment);
        } elseif (null !== $comment) {
            throw new FailureException(sprintf("Expecting comment to be %s, none given", $comment));
        }

        if ($variables) {
            if ($subject['variables'] != $variables) {
                $failure = new FailureException(
                    sprintf(
                        "Variables should be:\n %s \n-------\n %s",
                        var_export($variables, true),
                        var_export($subject['variables'], true)
                    )
                );

                throw $failure;
            }
        }
    }

    /**
     * @param string $name
     * @param string $shouldBe
     * @param string $currentValue
     *
     * @throws FailureException
     */
    private function compareAndThrow($name, $shouldBe, $currentValue)
    {
        if ($shouldBe !== $currentValue) {
            throw new FailureException(sprintf('%s should be "%s", "%s" given', $name, $currentValue, $shouldBe));
        }
    }

    function let()
    {
        $file = $this->getFileName();

        $this->beConstructedWith(file_get_contents($file), $file);
    }

    function it_should_be_supported()
    {
        $this->isSupported()->shouldReturn(true);
    }

    function it_is_parsing_file_correctly()
    {
        $parsed = $this->parse();

        $parsed->shouldHaveCount(3);

        $parsed->shouldBeProperlyParsed();
    }

    function it_should_throw_ParsingException_when_wrong_file()
    {
        $file = $this->getWrongFileName();

        $this->beConstructedWith(file_get_contents($file), $file);

        $this->shouldThrow('Hexmedia\Crontab\Exception\ParsingException')->duringParse();
    }

}
