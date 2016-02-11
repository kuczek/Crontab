<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser;

/**
 * Class ParserAbstract
 * @package Hexmedia\Crontab\Parser
 */
abstract class ParserAbstract implements ParserInterface
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
