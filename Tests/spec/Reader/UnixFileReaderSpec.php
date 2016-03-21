<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Reader;

use dev\Hexmedia\Crontab\PhpSpec\SystemAwareObjectBehavior;
use Prophecy\Argument;

class UnixFileReaderSpec extends SystemAwareObjectBehavior
{
    function let()
    {
        $this->isSystemSupported();
        $this->beConstructedWith("./Tests/example_configurations/test.unix");
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\UnixFileReader');
        $this->shouldImplement('Hexmedia\Crontab\Reader\AbstractUnixReader');
    }

    function it_is_readable() {
        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }

}
