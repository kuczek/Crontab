<?php

namespace Hexmedia\Crontab\Writer;

use Hexmedia\Crontab\Crontab;

interface WriterInterface
{
    /**
     * @param Crontab $crontab
     * @return bool
     */
    public function write(Crontab $crontab);

    /**
     * @param Crontab $crontab
     * @return string
     */
    public function getContent(Crontab $crontab);
}
