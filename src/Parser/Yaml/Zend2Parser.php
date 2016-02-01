<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:49
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class Zend2Parser
 * @package Hexmedia\Crontab\Parser\Yaml
 *
 * TODO: This class needs to be written with additional support for different yaml decoders.
 * TODO: currently will not work at all.
 */
class Zend2Parser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     */
    public function parse()
    {
        $parser = new \Zend\Config\Reader\Yaml();

        $config = $parser->fromFile($this->content);

        return $config;
    }

    public static function isSupported()
    {
        return false;
    }
}
