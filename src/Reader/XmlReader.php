<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Parser\Xml\ParserFactory;

/**
 * Class XmlReader
 *
 * @package Hexmedia\Crontab\Reader
 */
class XmlReader extends AbstractFileReader implements ReaderInterface
{
    /**
     * @return array
     */
    protected function getParserFactory()
    {
        return new ParserFactory();
    }
}
