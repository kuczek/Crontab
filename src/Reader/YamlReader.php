<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Yaml\ParserFactory;

/**
 * Class YamlReader
 * @package Hexmedia\Crontab\Reader
 */
class YamlReader extends FileReaderAbstractArrayReader implements ReaderInterface
{
    /**
     * @param string       $file
     * @param Crontab|null $crontab
     * @param string|null  $machine
     */
    public function __construct($file, Crontab $crontab = null, $machine = null)
    {
        parent::__construct($file, $crontab, $machine);
    }

    /**
     * @return array
     * @throws \Hexmedia\Crontab\Exception\NoSupportedParserException
     */
    protected function parse()
    {
        $parserFactory = new ParserFactory();

        $parser = $parserFactory->create($this->getFile());

        return $parser->parse();
    }
}
