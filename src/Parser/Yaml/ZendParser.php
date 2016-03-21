<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class ZendParser
 *
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class ZendParser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     *
     * @throws ParsingException
     */
    public function parse()
    {
        try {
            $parser = new \Zend_Config_Yaml($this->getFile());
        } catch (\Zend_Config_Exception $e) {
            throw new ParsingException("Cannot parse this file: " . $e->getMessage(), 0, $e);
        }

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
