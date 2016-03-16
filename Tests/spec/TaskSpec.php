<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab;

use Hexmedia\Crontab\Variables;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class TaskSpec
 *
 * @package spec\Hexmedia\Crontab
 *
 * @covers Hexmedia\Reader\Task
 */
class TaskSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Task');
    }

    function it_allows_to_set_is_not_managed()
    {
        $this->setNotManaged(true)->shouldReturn($this);
        $this->isNotManaged()->shouldReturn(true);

        $this->setNotManaged("aaa")->shouldReturn($this);
        $this->isNotManaged()->shouldReturn(false);
    }

    function it_allows_to_set_name()
    {
        $this->setName("name")->shouldReturn($this);
        $this->getName()->shouldReturn("name");
    }

    function it_allows_to_set_month()
    {
        $this->setMonth("*")->shouldReturn($this);
        $this->getMonth()->shouldReturn("*");
    }

    function it_allows_to_set_minute()
    {
        $this->setMinute("*")->shouldReturn($this);
        $this->getMinute()->shouldReturn("*");
    }

    function it_allows_to_set_hour()
    {
        $this->setHour("*")->shouldReturn($this);
        $this->getHour()->shouldReturn("*");
    }

    function it_allows_to_set_log_file()
    {
        $this->setLogFile("/var/log_file")->shouldReturn($this);
        $this->getLogFile()->shouldReturn("/var/log_file");
    }

    function it_allows_to_set_day_of_month()
    {
        $this->setDayOfMonth("*")->shouldReturn($this);
        $this->getDayOfMonth()->shouldReturn("*");
    }

    function it_allows_to_set_day_of_week()
    {
        $this->setDayOfWeek("*")->shouldReturn($this);
        $this->getDayOfWeek()->shouldReturn("*");
    }

    function it_allows_to_set_before_comment()
    {
        $this->setBeforeComment("Some Comment")->shouldReturn($this);
        $this->getBeforeComment()->shouldReturn("Some Comment");
    }

    function it_allows_to_set_variables(Variables $variables)
    {
        $this->setVariables($variables)->shouldReturn($this);
        $this->getVariables()->shouldReturn($variables);
    }

    function it_allows_to_set_command()
    {
        $this->setCommand("acme:bundle")->shouldReturn($this);
        $this->getCommand()->shouldReturn("acme:bundle");
    }
}
