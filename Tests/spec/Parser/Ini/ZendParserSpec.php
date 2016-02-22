<?php

namespace spec\Hexmedia\Crontab\Parser\Ini;

use dev\Hexmedia\Crontab\PhpSpec\Parser\IniParserObjectBehavior;
use Prophecy\Argument;

class ZendParserSpec extends IniParserObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Ini\ZendParser');
    }
}
