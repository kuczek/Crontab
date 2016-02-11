<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class SymfonyParser
 * @package Hexmedia\Crontab\Parser\Yaml
 */
class SymfonyParser extends AbstractParser implements ParserInterface
{
    /**
     * @return array
     */
    public function parse()
    {
        $parser = new \Symfony\Component\Yaml\Parser();

        $parsed = $parser->parse(file_get_contents($this->content));

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
