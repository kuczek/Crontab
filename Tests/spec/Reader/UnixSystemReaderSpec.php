<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

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
}
