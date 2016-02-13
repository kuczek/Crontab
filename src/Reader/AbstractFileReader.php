<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;

/**
 * Class FileReaderAbstract
 * @package Hexmedia\Crontab\Reader
 */
abstract class AbstractFileReader extends AbstractArrayReader
{
    /**
     * @var string
     */
    private $file;

    /**
     * FileReader constructor.
     * @param null         $file
     * @param Crontab|null $crontab
     * @param null         $machine
     */
    public function __construct($file = null, Crontab $crontab = null, $machine = null)
    {
        parent::__construct($crontab, $machine);

        $this->file = $file;
    }

    /**
     * @return array
     */
    public function prepareArray()
    {
        $parsed = $this->parse();

        return $parsed;
    }

    /**
     * Reads all crons from given file, and puts them into crontab.
     *
     * @return Crontab
     */
    public function read()
    {
        $parsed = $this->parse();

        return $this->readArray($parsed);
    }

    /**
     * @return string
     */
    protected function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    protected function getContent()
    {
        return file_get_contents($this->getFile());
    }

    /**
     * @return array
     */
    abstract protected function parse();
}
