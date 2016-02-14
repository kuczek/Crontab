<?php

/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\CrontabDev\PhpSpec\Parser;

use Hexmedia\Crontab\Exception\NoSupportedParserException;
use Hexmedia\Crontab\Exception\UnexistingParserException;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

/**
 * Class FactoryObjectBehavior
 */
abstract class FactoryObjectBehavior extends ObjectBehavior
{
    private $notWorkingParser = 'Hexmedia\Crontab\Parser\Ini\SomeParser';

    abstract protected function getType();

    abstract protected function getWorkingParser();

    abstract protected function getParsersCount();

    private function getFullWorkingParserName()
    {
        return 'Hexmedia\Crontab\Parser\\' . $this->getType() . '\\' . $this->getWorkingParser();
    }

    function it_is_correctly_defined_working_parser()
    {//Test for tests:P
        if (!class_exists($this->getFullWorkingParserName())) {
            throw new FailureException("Working class does not exists. Tests will not work!");
        }
    }

    function it_has_all_default_parser_that_exists()
    {
        foreach ($this->getParsers()->getWrappedObject() as $parser) {
            if (!class_exists($parser)) {
                throw new FailureException(
                    sprintf("Parser %s does not exists. And is defined as default!", $parser)
                );
            }
        }
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\\' . $this->getType() . '\ParserFactory');
        $this->shouldImplement('Hexmedia\Crontab\Parser\AbstractParserFactory');
    }

    function it_is_able_to_add_supported_parser()
    {
        $this->addParser($this->getFullWorkingParserName())->shouldReturn($this);
    }

    function it_is_not_able_to_add_unexisting_class_as_parser()
    {
        $this->shouldThrow(
            new UnexistingParserException(sprintf('Parser %s does not exists!', $this->notWorkingParser))
        )
            ->duringAddParser($this->notWorkingParser);
    }

    function it_is_able_to_remove_existing_parser()
    {
        $this->removeParser($this->getFullWorkingParserName())->shouldReturn(true);
        $this->getParsers()->shouldHaveCount($this->getParsersCount() - 1);
    }

    function it_is_not_able_to_remove_unexisting_parser()
    {
        $this->removeParser($this->notWorkingParser)->shouldReturn(false);
        $this->getParsers()->shouldHaveCount($this->getParsersCount());
    }

    function it_returns_correct_praser()
    {
        $this->create('')->shouldImplement('Hexmedia\Crontab\Parser\ParserInterface');
    }

    function it_is_constructing_with_prefered_full_name()
    {
        $this->beConstructedWith($this->getFullWorkingParserName());
        $this->create("[some]")->shouldHaveType($this->getFullWorkingParserName());
    }

    function it_is_constructing_with_prefered_only_class_name()
    {
        $this->beConstructedWith($this->getWorkingParser());
        $this->create("[some]")->shouldHaveType($this->getFullWorkingParserName());
    }

    function it_is_allowing_to_get_parsers()
    {
        $this->getParsers()->shouldHaveCount($this->getParsersCount());
    }

    function it_is_throwing_when_there_is_no_parser()
    {
        $this->clearParser()->shouldReturn($this);
        $this->getParsers()->shouldHaveCount(0);

        $this
            ->shouldThrow(
                new  NoSupportedParserException('There is no supported parser for this type.')
            )
            ->duringCreate('some text');
    }
}
