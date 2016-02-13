<?php
/**
 * @copyright 2013-2016 Hexmedia.pl
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
