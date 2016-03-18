<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Ini;

use dev\Hexmedia\Crontab\PhpSpec\Parser\AbstractIniParserObjectBehavior;
use Prophecy\Argument;

/**
 * Class AustinHydeParserSpec
 *
 * @package spec\Hexmedia\Crontab\Parser\Ini
 */
class AustinHydeParserSpec extends AbstractIniParserObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Ini\AustinHydeParser');
    }
}
