<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Yaml\ParserFactory;

/**
 * Class YamlReader
 *
 * @package Hexmedia\Crontab\Reader
 */
class YamlReader extends AbstractFileReader implements ReaderInterface
{
    /**
     * @return array
     */
    protected function getParserFactory()
    {
        return new ParserFactory();
    }
}
