<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;
use Zend\Config\Exception\RuntimeException;

/**
 * Class Zend2Parser
 *
 * @package Hexmedia\Crontab\Parser\Ini
 */
class Zend2Parser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     *
     * @throws ParsingException
     */
    public function parse()
    {
        try {
            $parser = new \Zend\Config\Reader\Ini();

            $config = $parser->fromFile($this->getFile());
        } catch (RuntimeException $e) {
            throw new ParsingException("Cannot parse this file: " . $e->getMessage(), 0, $e);
        }

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
