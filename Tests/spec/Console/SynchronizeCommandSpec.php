<?php

namespace spec\Hexmedia\Crontab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SynchronizeCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Console\SynchronizeCommand');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

}
