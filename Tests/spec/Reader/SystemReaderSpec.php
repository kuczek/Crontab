<?php

namespace spec\Hexmedia\Crontab\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SystemReaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith("kuczek", null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\SystemReader');
        $this->shouldImplement('Hexmedia\Crontab\Reader\ReaderInterface');
    }

    function it_is_working_only_on_linux_and_bsd_currently()
    {
        if (in_array(PHP_OS, array('Linux', 'FreeBSD'))) {

        }
    }

    function it_has_readers()
    {
        $this->getReaders()->shouldHaveCount(1);
    }

    function it_is_able_to_add_reader()
    {
        $reader = "Hexmedia\\Crontab\\Reader\\WindowsSystemReader";

        $this->addReader($reader)->shouldReturn($this);

        $readers = $this->getReaders();

        $readers->shouldHaveCount(2);
        $readers[1]->shouldReturn($reader);
    }

    function it_is_not_able_to_remove_unexisting_reader()
    {
        $reader = "Hexmedia\\Crontab\\Reader\\AndroidReader";

        $this->removeReader($reader)->shouldReturn($this);

        $this->getReaders()->shouldHaveCount(1);
    }

    function it_is_able_to_remove_reader()
    {
        $reader = "Hexmedia\\Crontab\\Reader\\WindowsSystemReader";

        $this->removeReader($reader)->shouldReturn($this);

        $readers = $this->getReaders();

        $readers->shouldHaveCount(1);
    }

    function it_is_able_to_read()
    {
        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }
}
