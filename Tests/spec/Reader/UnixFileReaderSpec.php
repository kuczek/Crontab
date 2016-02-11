<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

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
        $this->shouldImplement('Hexmedia\Crontab\Reader\UnixReaderAbstract');
    }

    function it_is_readable() {
        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }

}
