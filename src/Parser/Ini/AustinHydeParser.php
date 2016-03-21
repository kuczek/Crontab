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

/**
 * Class AustinHydeParser
 *
 * @package Hexmedia\Crontab\Parser\Ini
 */
class AustinHydeParser extends AbstractParser implements ParserInterface
{
    /**
     * @return \ArrayObject
     *
     * @throws ParsingException
     */
    public function parse()
    {
        {
            $this->setTemporaryErrorHandler();

            $parser = new \IniParser($this->getFile());

            /** @var \ArrayObject $parsed */
            $parsed = $parser->parse();

            $this->restoreErrorHandler();
        }

        $parsed = $this->transformToArray($parsed);

        return $parsed;
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\\IniParser');
    }

    /**
     * @param \ArrayObject $arrayObject
     *
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
}
