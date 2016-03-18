<?php

namespace spec\Hexmedia\Crontab\Parser\Yaml;

use dev\Hexmedia\Crontab\PhpSpec\Parser\AbstractYamlParserObjectBehavior;
use PhpSpec\Exception\Example\SkippingException;
use Prophecy\Argument;

class ZendParserSpec extends AbstractYamlParserObjectBehavior
{
    function let() {
        if (defined('HHVM_VERSION')) {
            throw new SkippingException("Zend is not compatible with HHVM.");
        }

        parent::let();
    }
}
