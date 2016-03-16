<?php

namespace spec\Hexmedia\Crontab\Parser\Xml;

use dev\Hexmedia\Crontab\PhpSpec\Parser\AbstractXmlParserObjectBehavior;
use Prophecy\Argument;

class PhpParserSpec extends AbstractXmlParserObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Xml\PhpParser');
    }
}
