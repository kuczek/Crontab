<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Writer;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Writer\System\WriterFactory;

/**
 * Class SystemWriter
 * @package Hexmedia\Crontab\Writer
 */
class SystemWriter implements WriterInterface
{
    /** @var System\WriterInterface|null writer */
    private $writer;

    /**
     * SystemWriter constructor.
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct()
    {
        $this->writer = WriterFactory::create();
    }

    /**
     * @param Crontab $crontab
     * @return bool
     */
    public function write(Crontab $crontab)
    {
        return $this->writer->write($crontab);
    }


    /**
     * @param Crontab $crontab
     * @return string
     */
    public function getContent(Crontab $crontab)
    {
        return $this->writer->getContent($crontab);
    }
}
