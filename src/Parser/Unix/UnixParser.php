<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace Hexmedia\Crontab\Parser\Unix;

use Hexmedia\Crontab\Exception\ParseException;
use Hexmedia\Crontab\Parser\AbstractParser;
use Hexmedia\Crontab\Parser\ParserInterface;

/**
 * Class UnixParser
 *
 * @package Hexmedia\Crontab\Parser\Unix
 */
class UnixParser extends AbstractParser implements ParserInterface
{
    /**
     * @var array
     */
    private static $supportedOs = array(
        'Linux',
        'FreeBSD',
    );

    /**
     * @return array
     * @throws ParseException
     */
    public function parse()
    {
        $content = "\n" . $this->getContent(); //a little trick
        //                                       to allow allow only rules that begins at the begining of line

        if (false === preg_match_all('/' . $this->getCrontabRegexRule() . '/', $content, $matches, PREG_SET_ORDER)) {
            throw new ParseException(sprintf("Cannot match this file error: '%s'", preg_last_error()));
        }

        $return = array();

        foreach ($matches as $match) {
            $return[] = $this->parseOneMatch($match);
        }

        return $return;
    }

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return in_array(PHP_OS, self::getSupportedOs());
    }

    /**
     * @param string $osName
     */
    public function addSupportedOs($osName)
    {
        self::$supportedOs[] = $osName;
    }

    /**
     * @param string $osName
     */
    public function removeSupportedOs($osName)
    {
        $key = array_search($osName, self::$supportedOs);

        unset(self::$supportedOs[$key]);
    }

    /**
     * Returns all operating systems supported by this *nix like library
     *
     * @return string[]
     */
    public static function getSupportedOs()
    {
        return self::$supportedOs;
    }

    /**
     * @param array $match
     *
     * @return array
     */
    private function parseOneMatch(array $match)
    {
        $array = array();

        $array['log_file'] = $match['logFile'];
        $array['command'] = trim($match['command']);
        $array['day_of_week'] = $match['dayOfWeek'];
        $array['day_of_month'] = $match['dayOfMonth'];
        $array['hour'] = $match['hours'];
        $array['minute'] = $match['minutes'];
        $array['month'] = $match['month'];

        $vAndC = $this->parseVariablesAndComments($match['vandc']);

        $array['comment'] = $vAndC['comment'];
        $array['variables'] = $vAndC['variables'];

        return $array;
    }

    /**
     * @param string $match
     *
     * @return array
     */
    private function parseVariablesAndComments($match)
    {
        $match = trim($match);
        $comment = '';
        $variables = array();

        if ($match) {
            if (preg_match_all('/' . $this->getVariableRule() . '/', $match, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $variables[$m['variable']] = $m['value'];
                }
            }

            if (preg_match_all('/' . $this->getCommentRule() . '/', $match, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $m) {
                    $comment .= trim($m['comment']) . "\n";
                }
            }
        }

        return array(
            'comment' => trim($comment),
            'variables' => $variables,
        );
    }

    /**
     * @return string
     */
    private function getCrontabRegexRule()
    {
        $crontabRule = '\n(?<minutes>([0-9]{1,2}|\*|\*\/[0-9]{1,2}))[\t\s]+' . '(?<hours>([0-9]{1,2}|\*|\*\/[0-9]{1,2}))[\t\s]+(?<dayOfMonth>([0-9]{1,2}|\*|\*\/[0-9]{1,2}))[\t\s]+' . '(?<month>([0-9]{1,2}|\*|\*\/[0-9]{1,2}))[\t\s]+(?<dayOfWeek>([0-9]{1,2}|\*|\*\/[0-9]{1,2}))[\t\s]+' . '(?<command>[^>]*)[\t\s]+(>[>\s\t]?(?<logFile>[a-zA-Z0-9\/\-\_:\.]*))?';
        $variableRule = sprintf('(%s\n?){0,}', $this->getVariableRule());
        $commentRule = sprintf('(%s\n?){0,}', $this->getCommentRule());

        $cAndVRule = '(?<vandc>(' . $commentRule . $variableRule . '){0,})';

        $rule = '(?<rule>' . $cAndVRule . $crontabRule . ')';

        return $rule;
    }

    /**
     * @return string
     */
    private function getCommentRule()
    {
        return '(#(?<comment>.*))';
    }

    /**
     * @return string
     */
    private function getVariableRule()
    {
        return '(?<variable>[A-Za-z0-9_]*)=(?<value>.*)';
    }
}
