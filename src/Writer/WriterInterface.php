<?php

namespace Hexmedia\Crontab\Writer;

use Hexmedia\Crontab\Crontab;

interface WriterInterface
{
    public function __construct(array $configuration = array());

    public function save(Crontab $crontab);
}
