<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\AbstractParserFactory;

/**
 * Class ParserFactory
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class ParserFactory extends AbstractParserFactory
{
    /**
     * @return array
     */
    public function getDefaultParsers()
    {
        $supported = array('\\Hexmedia\\Crontab\\Parser\\Yaml\\SymfonyParser');

        if (!defined('HHVM_VERSION')) {
            $supported[] = '\\Hexmedia\\Crontab\\Parser\\Yaml\\ZendParser';
        }

        return $supported;
    }
}
