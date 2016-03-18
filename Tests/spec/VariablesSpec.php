<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab;

use Hexmedia\Crontab\Exception\UnsupportedVariableException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class VariablesSpec
 *
 * @package spec\Hexmedia\Crontab
 *
 * @covers Hexmedia\Variables
 */
class VariablesSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(array(
            'FIRST' => '1111',
            'SECOND' => '222',
            'THIRD' => '33'
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\Hexmedia\Crontab\Variables');
        $this->shouldImplement('\Iterator');
    }

    function it_can_get_current()
    {
        $this->current()->shouldReturn('1111');
    }

    function it_can_go_next()
    {
        $this->next();

        $this->current()->shouldReturn('222');
    }

    function it_can_rewind()
    {
        $this->rewind();

        $this->current()->shouldReturn('1111');
    }

    function it_has_working_validation()
    {
        $this->next();

        $this->valid()->shouldReturn(true);

        $this->next();
        $this->next();
        $this->next();

        $this->valid()->shouldReturn(false);
    }

    function it_is_returning_correct_keys()
    {
        $this->rewind();

        $this->key()->shouldReturn("FIRST");
        $this->next();
        $this->key()->shouldReturn("SECOND");
    }
}
