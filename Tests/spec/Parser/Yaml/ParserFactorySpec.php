<?php

namespace spec\Hexmedia\Crontab\Parser\Yaml;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Yaml\ParserFactory');
    }
}
