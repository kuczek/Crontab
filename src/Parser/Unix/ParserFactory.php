<?php
/**
 * Created by PhpStorm.
 * User: krun
 * Date: 31.01.16
 * Time: 00:34
 */

namespace Hexmedia\Crontab\Parser\Unix;


use Hexmedia\Crontab\Parser\ParserFactoryAbstract;

class ParserFactory extends ParserFactoryAbstract
{
    public function getDefaultParsers()
    {
        return array(
            "\\Hexmedia\\Crontab\\Parser\\Unix\\UnixParser",
        );
    }
}