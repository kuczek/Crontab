<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
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
