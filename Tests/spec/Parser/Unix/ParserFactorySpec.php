<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace spec\Hexmedia\Crontab\Parser\Unix;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Unix\ParserFactory');
        $this->shouldImplement('Hexmedia\Crontab\Parser\AbstractParserFactory');
    }
}
