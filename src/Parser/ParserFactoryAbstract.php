<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Parser;

use Hexmedia\Crontab\Exception\NoSupportedParserException;
use Hexmedia\Crontab\Exception\UnexistingParserException;

/**
 * Class ParserFactoryAbstract
 * @package Hexmedia\Crontab\Parser
 */
abstract class ParserFactoryAbstract
{
    /**
     * @var array|mixed
     */
    protected $parsers = array();

    /**
     * ParserFactoryAbstract constructor.
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
     * @throws UnexistingParserException
     */
    public function addParser($className)
    {
        if (!class_exists($className)) {
            throw new UnexistingParserException(sprintf('Parser %s does not exists!', $className));
        }

        $this->parsers[] = $className;
    }

    /**
     * @param string $className
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
     * @param string $content
     * @return ParserInterface
     * @throws NoSupportedParserException
     */
    public function create($content)
    {
        foreach ($this->parsers as $parserName) {
            if (call_user_func($parserName . '::isSupported')) {
                return new $parserName($content);
            }
        }

        throw new NoSupportedParserException('There is no supported parser for this type.');
    }

    /**
     * @param string $preferred
     * @return string
     */
    protected function searchForKey($preferred)
    {
        $key = array_search($preferred, $this->parsers);

        if (false === $key) {
            foreach ($this->parsers as $key2 => $parser) {
                if (preg_match('/\\\\([A-Za-z0-9]*)$/', $parser, $matches)) {
                    if ($matches[1] == $preferred) {
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
}
