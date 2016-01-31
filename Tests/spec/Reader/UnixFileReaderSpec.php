<?php

namespace spec\Hexmedia\Crontab\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnixFileReaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("./Test/example_configurations/test.unix");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\UnixFileReader');
        $this->shouldImplement('Hexmedia\Crontab\Reader\UnixReader');
    }

    function it_is_readable() {
        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }

}