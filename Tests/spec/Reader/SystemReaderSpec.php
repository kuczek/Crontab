<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Reader;

use dev\Hexmedia\Crontab\PhpSpec\SystemAwareObjectBehavior;
use Hexmedia\Crontab\Exception\ClassNotExistsException;
use Prophecy\Argument;

/**
 * Class SystemReaderSpec
 *
 * @package spec\Hexmedia\Crontab\Reader
 *
 * @covers Hexmedia\Crontab\Reader\SystemReader
 */
class SystemReaderSpec extends SystemAwareObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(null, null);
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
        $this->isSystemSupported();

        $this->getReaders()->shouldHaveCount(1);
    }

    function it_is_able_to_remove_and_add_reader()
    {
        $this->isSystemSupported();

        $reader = "Hexmedia\\Crontab\\Reader\\UnixSystemReader";

        $this->getReaders()->shouldHaveCount(1);
        $this->removeReader($reader)->shouldReturn($this);
        $this->getReaders()->shouldHaveCount(0);
        $this->addReader($reader)->shouldReturn($this);

        $readers = $this->getReaders();
        $readers->shouldHaveCount(1);
        $readers[0]->shouldReturn('\\' . $reader);
    }

    function it_is_not_able_to_add_non_existing_class()
    {
        $this->isSystemSupported();

        $reader = "\\Hexmedia\\Crontab\\Reader\\WindowsSystemReader";

        $this
            ->shouldThrow(
                new ClassNotExistsException(
                    sprintf("Class %s does not exists. Cannot be added as Reader.", $reader)
                )
            )->duringAddReader($reader);
    }

    function it_is_not_able_to_remove_unexisting_reader()
    {
        $this->isSystemSupported();

        $reader = "Hexmedia\\Crontab\\Reader\\AndroidReader";

        $this->removeReader($reader)->shouldReturn($this);

        $this->getReaders()->shouldHaveCount(1);
    }

    function it_is_able_to_remove_reader()
    {
        $this->isSystemSupported();

        $reader = "Hexmedia\\Crontab\\Reader\\WindowsSystemReader";

        $this->removeReader($reader)->shouldReturn($this);

        $readers = $this->getReaders();

        $readers->shouldHaveCount(1);
    }

    function it_is_able_to_read()
    {
        $this->isSystemSupported();

        $readed = $this->read();

        $readed->shouldHaveType('Hexmedia\Crontab\Crontab');
    }
}
