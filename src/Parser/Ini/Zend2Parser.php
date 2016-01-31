<?php

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 15:45
 */
class Zend2Parser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     */
    public function parse()
    {
        $parser = new \Zend\Config\Reader\Ini();

        $config = $parser->fromFile($this->content);

        return $config;
    }

    public static function isSupported()
    {
        return class_exists("\\Zend\\Config\\Reader\\Ini");
    }
}
