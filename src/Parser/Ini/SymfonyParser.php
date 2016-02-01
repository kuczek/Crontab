<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:46
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\AbstractParser;

class SymfonyParser extends AbstractParser
{

    /**
     * @return array
     */
    public function parse()
    {
        throw new \Exception("Implement me!");
    }

    public static function isSupported()
    {
        return false;
    }
}
