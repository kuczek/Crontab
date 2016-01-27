<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 16:50
 */

namespace Hexmedia\Crontab\Parser;

abstract class AbstractParser implements ParserInterface
{
    protected $file;

    public function __construct($file)
    {
        $this->file = $file;
    }
}
