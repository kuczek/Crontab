<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 12:35
 */

namespace Hexmedia\Crontab\Reader;


use Hexmedia\Crontab\Crontab;

abstract class FileReader extends ArrayReader
{
    /**
     * @var string
     */
    private $file;

    /**
     * FileReader constructor.
     * @param null $file
     * @param Crontab|null $crontab
     * @param null $machine
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

    protected function getFile()
    {
        return $this->file;
    }

    protected function getContent()
    {
        return file_get_contents($this->getFile());
    }

    /**
     * @return array
     */
    protected abstract function parse();
}
