<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:55
 */

namespace Hexmedia\Crontab\Parser\Yaml;

use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

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

    public static function isSupported()
    {
        return class_exists("\\Symfony\\Component\\Yaml\\Parser");
    }
}
