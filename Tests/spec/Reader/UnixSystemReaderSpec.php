<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Reader;

use dev\Hexmedia\Crontab\PhpSpec\SystemAwareObjectBehavior;
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
class UnixSystemReaderSpec extends SystemAwareObjectBehavior
{
    function let()
    {
        $this->isSystemSupported();
        $this->beConstructedWith(null, null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\UnixSystemReader');
        $this->shouldImplement('Hexmedia\Crontab\Reader\AbstractUnixReader');
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
