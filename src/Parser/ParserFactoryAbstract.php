<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-26
 * Time: 17:45
 */

namespace Hexmedia\Crontab\Parser;


use Hexmedia\Crontab\Exception\NoSupportedParserException;
use Hexmedia\Crontab\Exception\UnexistingParserException;

abstract class ParserFactoryAbstract
{
    protected $parsers = array();

    public function __construct($preferred = null)
    {
        $this->parsers = $this->getDefaultParsers();

        $this->sortWithPreferred($preferred);
    }

    public abstract function getDefaultParsers();

    public function addParser($className)
    {
        if (!class_exists($className)) {
            throw new UnexistingParserException(sprintf("Parser %s does not exists!", $className));
        }

        $this->parsers[] = $className;
    }

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
     * @param $file
     * @return ParserInterface
     * @throws NoSupportedParserException
     */
    public function create($file)
    {
        foreach ($this->parsers as $parserName) {
            if (call_user_func($parserName . "::isSupported")) {
                return new $parserName($file);
            }
        }

        throw new NoSupportedParserException("There is no supported parser for this type.");
    }

    protected function searchForKey($preferred)
    {
        $key = array_search($preferred, $this->parsers);

        if (false === $key) {
            foreach ($this->parsers as $key2 => $parser) {
                if (preg_match("/\\\\([A-Za-z0-9]*)$/", $parser, $matches)) {
                    if ($matches[1] == $preferred) {
                        return $key2;
                    }
                }
            }
        }

        return $key;
    }

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
