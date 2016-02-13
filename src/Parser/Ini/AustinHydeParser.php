<?php
/**
 * @copyright 2013-2016 Hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Ini;

use Hexmedia\Crontab\Parser\ParserAbstract;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class AustinHydeParser
 * @package Hexmedia\Crontab\Parser\Ini
 */
class AustinHydeParser extends ParserAbstract implements ParserInterface
{
    /**
     * @return \ArrayObject
     */
    public function parse()
    {
        $parser = new \IniParser($this->content);

        /** @var \ArrayObject $parsed */
        $parsed = $parser->parse();

        $parsed = $this->transformToArray($parsed);

        return $parsed;
    }

    /**
     * @param \ArrayObject $arrayObject
     * @return array
     */
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

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\\IniParser');
    }
}
