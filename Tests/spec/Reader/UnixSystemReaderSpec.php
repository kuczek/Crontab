<?php

namespace spec\Hexmedia\Crontab\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnixSystemReaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("kuczek", null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\UnixSystemReader');
        $this->shouldImplement('Hexmedia\Crontab\Reader\UnixReader');
    }

    function it_is_supported()
    {
        $this::isSupported()->shouldReturn(in_array(PHP_OS, array('Linux', "FreeBSD")));
    }

    function it_allows_to_read()
    {
        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }
}
