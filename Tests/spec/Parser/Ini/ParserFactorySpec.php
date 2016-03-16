<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Ini;

use dev\Hexmedia\Crontab\PhpSpec\Parser\FactoryObjectBehavior;
use Prophecy\Argument;

/**
 * Class ParserFactorySpec
 *
 * @package spec\Hexmedia\Crontab\Parser\Ini
 */
class ParserFactorySpec extends FactoryObjectBehavior
{
    protected function getType()
    {
        return "Ini";
    }

    protected function getWorkingParser()
    {
        return 'AustinHydeParser';
    }

    protected function getParsersCount()
    {
        if (defined("HHVM_VERSION")) {
            return 1;
        }

        return 3;
    }
}
