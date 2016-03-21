<?php

namespace spec\Hexmedia\Crontab;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ApplicationSpec
 *
 * @package spec\Hexmedia\Crontab
 *
 * @covers Hexmedia\Crontab\Application
 */
class ApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Application');
        $this->shouldImplement('Symfony\Component\Console\Application');
    }

    function it_has_added_all_commands()
    {
        $this->all()->shouldHaveCount(5);
    }
}
