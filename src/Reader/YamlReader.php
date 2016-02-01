<?php
/**
 * Created by PhpStorm.
 * User: kkuczek
 * Date: 2016-01-25
 * Time: 13:25
 */

namespace Hexmedia\Crontab\Reader;

use Hexmedia\Crontab\Crontab;
use Hexmedia\Crontab\Parser\Yaml\ParserFactory;

class YamlReader extends FileReader implements ReaderInterface
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

    protected function parse()
    {
        $parserFactory = new ParserFactory();

        $parser = $parserFactory->create($this->getFile());

        return $parser->parse();
    }
}
