<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser;

use Hexmedia\Crontab\Exception\NoSupportedParserException;
use Hexmedia\Crontab\Exception\UnexistingParserException;

/**
 * Class ParserFactoryAbstract
 *
 * @package Hexmedia\Crontab\Parser
 */
abstract class AbstractParserFactory
{
    /**
     * @var array|mixed
     */
    protected $parsers = array();

    /**
     * ParserFactoryAbstract constructor.
     *
     * @param string|null $preferred
     */
    public function __construct($preferred = null)
    {
        $this->parsers = $this->getDefaultParsers();

        $this->sortWithPreferred($preferred);
    }

    /**
     * @return array
     */
    abstract public function getDefaultParsers();

    /**
     * @param string $className
     *
     * @return $this
     * @throws UnexistingParserException
     */
    public function addParser($className)
    {
        if (!class_exists($className)) {
            throw new UnexistingParserException(sprintf('Parser %s does not exists!', $className));
        }

        $this->parsers[] = $className;

        return $this;
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function removeParser($className)
    {
        $key = $this->searchForKey($className);

        if (false !== $key) {
            unset($this->parsers[$key]);

            return true;
        }

        return false;
    }

    /**
     * @param string      $content
     * @param string|null $file
     *
     * @return ParserInterface
     * @throws NoSupportedParserException
     */
    public function create($content, $file)// = null)
    {
        foreach ($this->parsers as $parserName) {
            if (call_user_func($parserName . '::isSupported')) {
                return new $parserName($content, $file);
            }
        }

        throw new NoSupportedParserException(
            sprintf('There is no supported parser for this type or operating system (your is "%s").', PHP_OS)
        );
    }

    /**
     * @return array
     */
    public function getParsers()
    {
        return $this->parsers;
    }

    /**
     * @return $this;
     */
    public function clearParser()
    {
        $this->parsers = array();

        return $this;
    }

    /**
     * @param string $searched
     *
     * @return string
     */
    protected function searchForKey($searched)
    {
        $key = false;
        $searchedUnified = $this->unify($searched);

        foreach ($this->parsers as $key2 => $parser) {
            if ($searchedUnified == $this->unify($parser)) {
                $key = $key2;
                break;
            }
        }

        if (false === $key) {
            foreach ($this->parsers as $key2 => $parser) {
                if (preg_match('/\\\\([A-Za-z0-9]*)$/', $parser, $matches)) {
                    if ($matches[1] == $searched) {
                        return $key2;
                    }
                }
            }
        }

        return $key;
    }

    /**
     * @param string $preferred
     */
    private function sortWithPreferred($preferred)
    {
        if ($preferred) {
            $key = $this->searchForKey($preferred);

            if (false !== $key) {
                $preferred = $this->parsers[$key];
                unset($this->parsers[$key]);

                array_unshift($this->parsers, $preferred);
            }
        }
    }

    /**
     * Unifying class name for search
     *
     * @param string $className
     *
     * @return string
     */
    private function unify($className)
    {
        $className = trim($className, "\\/ \n");

        return preg_replace("/[^a-zA-Z0-9]*/", "/", $className);
    }
}
