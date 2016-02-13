<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReaderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\ReaderFactory');
    }

//    function it_is_not_created_without_type() {
//        $this->shouldThrow()->during('create', array(array()));
//    }

    function it_is_able_to_create_yaml_reader()
    {
        $this::create(array('type' => 'yaml', 'file' => 'aa'))->shouldHaveType('Hexmedia\Crontab\Reader\YamlReader');
    }
}
