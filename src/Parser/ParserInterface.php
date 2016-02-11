<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser;

/**
 * Interface ParserInterface
 * @package Hexmedia\Crontab\Parser
 */
interface ParserInterface
{
    /**
     * @return array
     */
    public function parse();

    /**
     * @return bool
     */
    public static function isSupported();
}
