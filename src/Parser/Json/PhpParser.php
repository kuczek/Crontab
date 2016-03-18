<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Json;

use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Parser\AbstractParser;

/**
 * Class PhpParser
 *
 * @package Hexmedia\Crontab\Parser\Json
 */
class PhpParser extends AbstractParser
{

    /**
     * @return array
     *
     * @throws ParsingException
     */
    public function parse()
    {
        $this->setTemporaryErrorHandler();

        $parsed = json_decode($this->getContent(), true);

        if (null === $parsed) {
            throw new ParsingException("Cannot parse file!");
        }

        $this->restoreErrorHandler();

        return $parsed;
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return true; //This is supported in php
    }
}
