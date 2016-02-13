<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class Zend2Parser
 * @package Hexmedia\Crontab\Parser\Ini
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

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\\Zend\\Config\\Reader\\Ini');
    }
}
