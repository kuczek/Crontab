<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\CrontabDev\PhpSpec\Parser;


class YamlParserObjectBehavior extends ParserObjectBehavior
{
    function let()
    {
        $iniFile = __DIR__ . '/../../../Tests/example_configurations/test.yaml';

        $this->beConstructedWith($iniFile);
    }
}
