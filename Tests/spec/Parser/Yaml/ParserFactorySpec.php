<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Yaml;

use dev\Hexmedia\Crontab\PhpSpec\Parser\FactoryObjectBehavior;
use Prophecy\Argument;

class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Yaml";
    }

    protected function getWorkingParser()
    {
        return "SymfonyParser";
    }

    protected function getParsersCount()
    {
        if (defined("HHVM_VERSION")) {
            return 1;
        }

        return 2;
    }
}
