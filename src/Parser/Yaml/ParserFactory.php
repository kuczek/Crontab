<?php
namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\ParserFactoryAbstract;

/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:45
 */
class ParserFactory extends ParserFactoryAbstract
{

    public function getDefaultParsers()
    {
        return array(
            "\\Hexmedia\\Crontab\\Parser\\Yaml\\SymfonyParser",
//            "\\Hexmedia\\Crontab\\Parser\\Yaml\\Zend2Parser",
            "\\Hexmedia\\Crontab\\Parser\\Yaml\\ZendParser",
        );
    }
}
