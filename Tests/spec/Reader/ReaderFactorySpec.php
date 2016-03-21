<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace spec\Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Exception\FactoryException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ReaderFactorySpec
 *
 * @package spec\Hexmedia\Crontab
 *
 * @covers  Hexmedia\Crontab\ReaderFactory
 */
class ReaderFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Reader\ReaderFactory');
    }

    function it_is_not_created_without_type()
    {
        $this->shouldThrow(
            new FactoryException('No type defined, you need to define type to create correct reader.')
        )->during('create', array(array()));
    }

    function it_is_not_created_with_wrong_type()
    {
        $type = "x";
        $this->shouldThrow(new FactoryException(sprintf("Unknown type '%s'", $type)))->during(
            'create',
            array(array('type' => $type))
        );
    }

    function it_is_able_to_create_standard_reader()
    {
        $this::create(array('type' => 'yaml', 'file' => 'aa'))->shouldHaveType('Hexmedia\Crontab\Reader\YamlReader');
    }

    function it_is_not_able_to_create_standard_reader_without_file()
    {
        $type = "xml";
        $this->shouldThrow(new FactoryException(sprintf('File needs to be defined for type %s', $type)))->during(
            "create",
            array(array("type" => $type))
        );
    }

    function it_is_able_to_create_unix_reader()
    {
        $this::create(array('type' => 'unix'))->shouldHaveType('Hexmedia\Crontab\Reader\UnixSystemReader');
    }

    function it_is_allowed_to_add_reader()
    {
        $this::getReaders()->shouldHaveCount(6);

        $this::addReader(
            'test',
            'dev\Hexmedia\Crontab\Test\TestReader',
            function ($configuration, $className) {
                return new $className();
            }
        );

        $this::getReaders()->shouldHaveCount(7);
    }

    function it_is_able_to_create_reader_initialized_with_custom_function()
    {
        $this::create(array('type' => 'test'))->shouldHaveType('dev\Hexmedia\Crontab\Test\TestReader');
    }

    function it_is_not_able_to_create_reader_with_non_existing_class()
    {
        $readerClass = "NonExistingClass";

        $this->shouldThrow(
            new FactoryException(
                sprintf("Class %s was not found and cannot be added as reader.", $readerClass)
            )
        )->during(
            'addReader',
            array(
                'z',
                $readerClass,
                function ($configuration, $class) {
                    return null;
                },
            )
        );
    }
}
