<?php

namespace spec\Hexmedia\Crontab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClearCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Console\ClearCommand');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
