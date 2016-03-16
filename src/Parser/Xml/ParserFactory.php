<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Xml;

use Hexmedia\Crontab\Parser\AbstractParserFactory;

/**
 * Class ParserFactory
 * @package Hexmedia\Crontab\Parser\Xml
 */
class ParserFactory extends AbstractParserFactory
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        return array(
            '\\Hexmedia\\Crontab\\Parser\\Xml\\PhpParser',
        );
    }
}
