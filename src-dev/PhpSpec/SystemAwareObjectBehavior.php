<?php

/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace dev\Hexmedia\Crontab\PhpSpec;

use Hexmedia\Crontab\System\Unix;
use PhpSpec\Exception\Example\SkippingException;
use PhpSpec\ObjectBehavior;

/**
 * Class SystemAwareObjectBehavior
 *
 * @package dev\Hexmedia\Crontab\PhpSpec
 */
class SystemAwareObjectBehavior extends ObjectBehavior
{
    protected function systemIsSupported()
    {
        if (false === Unix::isUnix()) {
            throw new SkippingException(
                sprintf('Your os "%s" is currently not supported.', PHP_OS)
            );
        }
    }
}
