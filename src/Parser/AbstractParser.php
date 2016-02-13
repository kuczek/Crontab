<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser;

/**
 * Class ParserAbstract
 *
 * @package Hexmedia\Crontab\Parser
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @var string
     */
    protected $content;

    /**
     * AbstractParser constructor.
     *
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
