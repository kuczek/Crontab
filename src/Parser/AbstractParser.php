<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser;

use Hexmedia\Crontab\Exception\ParsingException;

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
    private $content;

    /**
     * @var string
     */
    private $file;

    /**
     * AbstractParser constructor.
     *
     * @param string $content
     * @param string $file
     */
    public function __construct($content, $file)
    {
        $this->content = $content;
        $this->file = $file;
    }

    /**
     * @return string
     */
    protected function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    protected function getFile()
    {
        return $this->file;
    }

    /**
     *
     */
    protected function setTemporaryErrorHandler()
    {
        set_error_handler(
            function ($errorNumber, $errorString) {
                throw new ParsingException(sprintf('Cannot parse this file: (%d) %s', $errorNumber, $errorString));
            },
            E_ALL
        );
    }

    /**
     *
     */
    protected function restoreErrorHandler()
    {
        restore_error_handler();
    }
}
