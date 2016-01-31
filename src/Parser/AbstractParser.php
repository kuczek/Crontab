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
    /**
     * @var string
     */
    protected $content;

    /**
     * AbstractParser constructor.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
