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

    function it_has_correct_validation()
    {
        $array1 = array('a' => 'b');
        $arrayKeys1 = array_keys($array1);
        $exception1 = new UnsupportedVariableException(sprintf("Variable %s is not supported.", $arrayKeys1[0]));
        $array2 = array('MAILTO' => 'a', 'b' => 'c');
        $arrayKeys2 = array_keys($array2);
        $exception2 = new UnsupportedVariableException(sprintf("Variable %s is not supported.", $arrayKeys2[1]));

        $this->shouldThrow($exception1)->during('__construct', array($array1));
        $this->shouldThrow($exception2)->during('__construct', array($array2));
    }
}
