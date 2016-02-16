<?php

namespace spec\Hexmedia\Crontab\Parser\Ini;

use Hexmedia\CrontabDev\PhpSpec\Parser\FactoryObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Ini";
    }

    protected function getWorkingParser()
    {
        return 'AustinHydeParser';
    }

    protected function getParsersCount()
    {
        return 3;
    }
}
