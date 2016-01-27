<?php

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\ParserFactoryAbstract;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 15:28
 */
class ParserFactory extends ParserFactoryAbstract
{
    public function getDefaultParsers()
    {
        return array(
            "\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\Zend2Parser",
            "\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\ZendParser",
            "\\Hexmedia\\Crontab\\Crontab\\Parser\\Ini\\AustinHydeParser"
        );
    }
}
