<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Exception\FileNotFoundException;

/**
 * Class UnixFileReader
 * @package Hexmedia\Crontab\Reader
 */
class UnixFileReader extends UnixReaderAbstract
{
    /**
     * @var string
     */
    private $file;

    /**
     * UnixFileReader constructor.
     * @param string $file
     * @param Crontab|null $crontab
     */
    public function __construct($file, Crontab $crontab = null)
    {
        $this->file = $file;

        parent::__construct($crontab);
    }

    /**
     * @return mixed
     * @throws FileNotFoundException
     */
    protected function getContent()
    {
        if (false === file_exists($this->file)) {
            throw new FileNotFoundException(sprintf("File '%s' was not found!", $this->file));
        }

        return file_get_contents($this->file);
    }
}
