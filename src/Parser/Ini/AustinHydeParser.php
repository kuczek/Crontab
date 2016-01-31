<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 15:46
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

class AustinHydeParser extends AbstractParser implements ParserInterface
{
    public function parse()
    {
        $parser = new \IniParser($this->content);

        /** @var \ArrayObject $parsed */
        $parsed = $parser->parse();

        $parsed = $this->transformToArray($parsed);

        return $parsed;
    }

    private function transformToArray(\ArrayObject $arrayObject)
    {
        $array = $arrayObject->getArrayCopy();

        foreach ($array as $key => $value) {
            if ($value instanceof \ArrayObject) {
                $array[$key] = $this->transformToArray($value);
            }
        }

        return $array;
    }

    public static function isSupported()
    {
        return class_exists("\\IniParser");
    }
}
