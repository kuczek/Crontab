<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace dev\Hexmedia\Crontab\PhpSpec\Parser;

/**
 * Class AbstractYamlParserObjectBehavior
 *
 * @package dev\Hexmedia\Crontab\PhpSpec\Parser
 */
class AbstractYamlParserObjectBehavior extends AbstractParserObjectBehavior
{
    protected function getFileName()
    {
        return __DIR__ . '/../../../Tests/example_configurations/test.yml';
    }
}
