<?php

namespace spec\Hexmedia\Crontab\Parser\Ini;

use Hexmedia\CrontabDev\PhpSpec\Parser\IniParserObjectBehavior;
use Prophecy\Argument;

class AustinHydeParserSpec extends IniParserObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Ini\AustinHydeParser');
    }
}
