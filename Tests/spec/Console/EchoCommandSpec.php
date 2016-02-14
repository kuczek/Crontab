<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EchoCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Console\EchoCommand');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }
}
