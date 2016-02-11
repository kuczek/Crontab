<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Unix;

use Hexmedia\Crontab\Parser\ParserFactoryAbstract;

/**
 * Class ParserFactory
 * @package Hexmedia\Crontab\Parser\Unix
 */
class ParserFactory extends ParserFactoryAbstract
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        return array(
            "\\Hexmedia\\Crontab\\Parser\\Unix\\UnixParser",
        );
    }
}
