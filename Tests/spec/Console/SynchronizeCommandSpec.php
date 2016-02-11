<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace spec\Hexmedia\Crontab\Console;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SynchronizeCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Console\SynchronizeCommand');
        $this->shouldHaveType('Symfony\Component\Console\Command\Command');
    }

}
