<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Ini\ParserFactory;

/**
 * Class IniReader
 * @package Hexmedia\Crontab\Reader
 */
class IniReaderAbstract extends AbstractFileReaderAbstract implements ReaderInterface
{
    /**
     * @param null $file
     * @param Crontab|null $crontab
     * @param null $machine
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
