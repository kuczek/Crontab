<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Parser\Ini;

use dev\Hexmedia\Crontab\PhpSpec\Parser\AbstractIniParserObjectBehavior;
use PhpSpec\Exception\Example\SkippingException;
use Prophecy\Argument;

/**
 * Class Zend2ParserSpec
 *
 * @package spec\Hexmedia\Crontab\Parser\Ini
 */
class Zend2ParserSpec extends AbstractIniParserObjectBehavior
{
    function let() {
        if (defined('HHVM_VERSION')) {
            throw new SkippingException("Zend2 is not compatible with HHVM.");
        }

        parent::let();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Ini\Zend2Parser');
    }
}
