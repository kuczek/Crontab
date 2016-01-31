<?php

namespace spec\Hexmedia\Crontab;

use Hexmedia\Crontab\Exception\UnsupportedVariableException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VariablesSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(array('MAILTO' => 'k.kuczek@tvn.pl'));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\Hexmedia\Crontab\Variables');
        $this->shouldImplement('\Iterator');
    }
}
