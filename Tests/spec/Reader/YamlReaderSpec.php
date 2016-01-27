<?php

namespace spec\Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YamlReaderSpec extends ObjectBehavior
{
    function let(Crontab $crontab)
    {
        $file = "./Tests/example_configurations/test.yaml";
        $machine = "www101";
        $this->beConstructedWith($file, $crontab, $machine);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\YamlReader');
    }

    function it_is_returning_correct_value()
    {
        $read = $this->read();

        $read->shouldHaveType('Hexmedia\Crontab\Crontab');
    }
}
