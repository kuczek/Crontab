<?php

namespace spec\Hexmedia\Crontab\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UnixSystemReaderSpec
 * @package spec\Hexmedia\Crontab\Reader
 *
 * @method string read()
 * @method static bool isSupported()
 * @method static $this addSupportedOs(string $name)
 * @method static $this removeSupportedOs(string $name)
 * @method static array getSupportedOses()
 */
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

    function it_allows_to_get_all_supported_os()
    {
        $this::getSupportedOses()->shouldHaveCount(2);
    }

    function it_allows_to_add_supported_os()
    {
        $this::addSupportedOs("WinNT")->shouldReturn(true);

        $this::getSupportedOses()->shouldHaveCount(3);
    }

    function it_allows_to_remove_supported_os()
    {
        $this::removeSupportedOs("WinNT")->shouldReturn(true);

        $this::getSupportedOses()->shouldHaveCount(2);
    }

    function it_do_not_allows_to_remove_unexisting_supported_os()
    {
        $this::removeSupportedOs("WinNT")->shouldReturn(false);

        $this::getSupportedOses()->shouldHaveCount(2);
    }
}
