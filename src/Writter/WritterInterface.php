<?php

namespace Hexmedia\Writter;

use Hexmedia\Crontab;

interface WritterInterface
{
    public function __construct(array $configuration = array());

    public function save(Crontab $crontab);
}
