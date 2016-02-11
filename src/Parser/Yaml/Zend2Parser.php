<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\ParserAbstract;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class Zend2Parser
 * @package Hexmedia\Crontab\Parser\Yaml
 *
 * TODO: This class needs to be written with additional support for different yaml decoders.
 * TODO: currently will not work at all.
 */
class Zend2ParserAbstract extends ParserAbstract implements ParserInterface
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

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return false;
    }
}
