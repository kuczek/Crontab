<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 15:45
 */

namespace Hexmedia\Crontab\Parser;

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
