<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class ZendParser
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class ZendParser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     */
    public function parse()
    {
        $parser = new \Zend_Config_Yaml($this->content);

        return $parser->toArray();
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\\Zend_Config_Yaml');
    }
}
