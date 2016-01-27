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

    protected function getFile()
    {
        return $this->file;
    }

    public function read()
    {
        $parsed = $this->parse();

        return $this->readArray($parsed);
    }

    protected function readFile()
    {
        return file_get_contents($this->getFile());
    }

    protected abstract function parse();
}
