<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Exception\ParsingException;
use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class SymfonyParser
 *
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class SymfonyParser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     *
     * @throws ParsingException
     */
    public function parse()
    {
        try {
            $parser = new \Symfony\Component\Yaml\Parser();

            $parsed = $parser->parse($this->getContent());
        } catch (ParseException $e) {
            throw new ParsingException("Cannot parse this file: " . $e->getMessage(), 0, $e);
        }

        return $parsed;
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return class_exists('\\Symfony\\Component\\Yaml\\Parser');
    }
}
