<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\AbstractParserFactory;

/**
 * Class ParserFactory
 *
 * @package Hexmedia\Crontab\Parser\Ini
 */
class ParserFactory extends AbstractParserFactory
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        $supported = array();

        if (!defined("HHVM_VERSION")) {
            $supported[] = '\Hexmedia\Crontab\Parser\Ini\Zend2Parser';
            $supported[] = '\Hexmedia\Crontab\Parser\Ini\ZendParser';
        }

        $supported[] = '\Hexmedia\Crontab\Parser\Ini\AustinHydeParser';

        return $supported;
    }
}
