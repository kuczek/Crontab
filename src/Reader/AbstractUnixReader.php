<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Unix\ParserFactory;
use Hexmedia\Crontab\Parser\Unix\UnixParser;

/**
 * Class UnixReaderAbstract
 *
 * @package Hexmedia\Crontab\Reader
 */
abstract class AbstractUnixReader extends AbstractArrayReader
{
    /**
     * UnixReader constructor.
     *
     * @param Crontab|null $crontab
     */
    public function __construct(Crontab $crontab = null)
    {
        parent::__construct($crontab, null);
        $this->setNotManaged(true);
    }

    /**
     * @return array
     */
    protected function prepareArray()
    {
        $content = $this->getContent();

        $factory = new ParserFactory();
        $parser = $factory->create($content, null);

        return $parser->parse();
    }

    /**
     * @return mixed
     */
    abstract protected function getContent();
}
