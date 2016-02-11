<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\ParserFactoryAbstract;

/**
 * Class ParserFactory
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class ParserFactory extends ParserFactoryAbstract
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        return array(
            '\\Hexmedia\\Crontab\\Parser\\Yaml\\SymfonyParser',
            '\\Hexmedia\\Crontab\\Parser\\Yaml\\ZendParser',
        );
    }
}
