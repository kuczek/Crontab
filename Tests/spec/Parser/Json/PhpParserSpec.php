<?php

namespace spec\Hexmedia\Crontab\Parser\Json;

use dev\Hexmedia\Crontab\PhpSpec\Parser\AbstractJsonParserObjectBehavior;
use Prophecy\Argument;

class PhpParserSpec extends AbstractJsonParserObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Json\PhpParser');
    }
}
