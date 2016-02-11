<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace spec\Hexmedia\Crontab\Writer\System;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Exception\NoWriterForSystemException;
use Hexmedia\Crontab\Exception\WriterNotExistsException;
use Hexmedia\Crontab\System\Unix;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WriterFactorySpec extends ObjectBehavior
{
    /**
     * @var string
     */
    private $linuxWriterClass = 'Hexmedia\Crontab\Writer\System\UnixWriter';

    /**
     * @var array
     */
    private $orginalWriters;

    function let()
    {
        $this->orginalWriters = $this->getWriters();
    }

    function letgo()
    {
        $this->setWriters($this->orginalWriters);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Writer\System\WriterFactory');
    }

    function it_is_able_to_create_writer(Crontab $crontab)
    {
        $created = $this::create($crontab);

        $created->shouldImplement('Hexmedia\Crontab\Writer\System\WriterInterface');

        if (Unix::isUnix()) {
            $created->shouldImplement('Hexmedia\Crontab\Writer\System\UnixWriter');
        }
    }

    function it_returns_writers()
    {
        $this::getWriters()->shouldHaveCount(1);
    }

    function it_is_able_to_remove_writer()
    {
        $this::removeWriter($this->linuxWriterClass);
        $this::getWriters()->shouldHaveCount(sizeof($this->orginalWriters) - 1);
    }

    function it_is_returning_false_when_trying_to_remove_unexisting_writer()
    {
        $this::removeWriter("test")->shouldReturn(false);
    }

    function it_is_able_to_add_writer()
    {
        $this::addWriter($this->linuxWriterClass);
        $writers = $this::getWriters();

        $writers->shouldHaveCount(sizeof($this->orginalWriters) + 1);
        $writers[1]->shouldReturn('Hexmedia\Crontab\Writer\System\UnixWriter');
    }

    function it_is_throwing_error_when_trying_to_add_unexisting_writter()
    {
        $this->shouldThrow(new WriterNotExistsException(
            sprintf("Writer with given name %s does not exists.", 'test')
        ))->during('addWriter', array('test'));
    }

    function it_is_throwin_exception_when_there_is_no_supporting_system(Crontab $crontab)
    {
        $this::removeWriter($this->linuxWriterClass);
        $this::getWriters()->shouldHaveCount(0);


        $this->shouldThrow(new NoWriterForSystemException(
            sprintf("Writer for your operating system '%s' was not found!", PHP_OS)
        ))->duringCreate("test", array($crontab));
    }

    function it_allows_to_set_writers()
    {
        $this::setWriters(array());
        $this::getWriters()->shouldReturn(array());

    }
}
