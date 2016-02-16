<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Unix;

use dev\Hexmedia\Crontab\PhpSpec\Parser\FactoryObjectBehavior;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Unix";
    }

    protected function getWorkingParser()
    {
        return "UnixParser";
    }

    protected function getParsersCount()
    {
        return 1;
    }
}
