<?php

namespace spec\Hexmedia\Crontab\Parser\Xml;

use dev\Hexmedia\Crontab\PhpSpec\Parser\FactoryObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Xml";
    }

    protected function getWorkingParser()
    {
        return 'PhpParser';
    }

    protected function getParsersCount()
    {
        return 1;
    }
}
