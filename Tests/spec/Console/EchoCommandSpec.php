<?php

namespace spec\Hexmedia\Crontab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EchoCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Console\EchoCommand');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
