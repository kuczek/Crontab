<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Ini\ParserFactory;

/**
 * Class IniReader
 *
 * @package Hexmedia\Crontab\Reader
 */
class IniReader extends AbstractFileReader implements ReaderInterface
{
    /**
     * @return ParserFactory
     */
    protected function getParserFactory()
    {
        return new ParserFactory();
    }
}
