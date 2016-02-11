<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\ParserFactoryAbstract;

/**
 * Class ParserFactory
 * @package Hexmedia\Crontab\Parser\Ini
 */
class ParserFactory extends ParserFactoryAbstract
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        return array(
            '\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\Zend2Parser',
            '\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\ZendParser',
            '\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\AustinHydeParser'
        );
    }
}
