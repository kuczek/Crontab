<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Unix;

use dev\Hexmedia\Crontab\PhpSpec\Parser\FactoryObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ParserFactorySpec
 *
 * @package spec\Hexmedia\Crontab\Parser\Unix
 */
class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Unix";
    }

    protected function getWorkingParser()
    {
        return "UnixParser";
    }

    protected function getParsersCount()
    {
        return 1;
    }

    function it_returns_correct_praser()
    {
        $this->systemIsSupported();

        $this->create('')->shouldImplement('Hexmedia\Crontab\Parser\ParserInterface');
    }

    function it_is_constructing_with_prefered_full_name()
    {
        $this->systemIsSupported();

        $this->beConstructedWith($this->getFullWorkingParserName());
        $this->create("[some]")->shouldHaveType($this->getFullWorkingParserName());
    }

    function it_is_constructing_with_prefered_only_class_name()
    {
        $this->systemIsSupported();

        $this->beConstructedWith($this->getWorkingParser());
        $this->create("[some]")->shouldHaveType($this->getFullWorkingParserName());
    }

}
