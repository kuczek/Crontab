<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace spec\Hexmedia\Crontab\Parser\Unix;

use Hexmedia\Crontab\Parser\Unix\UnixParser;
use Hexmedia\Crontab\Parser\Unix\UnixParserAbstract;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnixParserSpec extends ObjectBehavior
{
    function let()
    {
        $file = __DIR__ . '/../../../example_configurations/test.unix';

        $content = file_get_contents($file);

        $this->beConstructedWith($content);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\Parser\Unix\UnixParser');
//        $this->shouldImplement('Hexmedia\Crontab\Parser\Unix\AbstractParser');
    }

    function it_should_be_supported_on_specified_devices()
    {
        $supportedOS = UnixParser::getSupportedOs();

        $this::isSupported()->shouldReturn(in_array(PHP_OS, $supportedOS));
    }

    function it_is_returning_supported_operating_systems()
    {
        $this::getSupportedOs()->shouldHaveCount(2);
    }

    function it_is_possible_to_add_supported_os()
    {
        $name = "WINNT";

        $this::addSupportedOs($name)->shouldReturn(null);
        $this::getSupportedOs()->shouldHaveCount(3);
    }

    function it_is_possible_to_remove_supported_os()
    {
        $name = "Linux";

        $this::removeSupportedOs($name)->shouldReturn(null);
        $this::getSupportedOs()->shouldHaveCount(2);
    }

    function it_is_loading_file_correctly()
    {
        $parsed = $this->parse();

        $parsed->shouldHaveCount(4);

        $commands = array(
            './mwe:photo:s3 asgasg afasf',
            './crobtabaction.php -- -pht',
            'ant build',
            '. ./do some thing98'
        );

        $minutes = array('*/26', "13", '50', "*");
        $hours = array('*/14', "23", "13", "*");
        $dayOfMonth = array('*/2', "18", "*/10", "*");
        $month = array('12', "8", "*/3", "*");
        $dayOfWeek = array('*/3', "0", "5", "*");
        $variables = array(
            array(
                'AND_SOME_VAR_FOR_NOT_MANAGED' => '1',
                'AND_ANOTHER_VAR' => '2'
            ),
            array(),
            array(
                'MAILTO' => 'test@test.com'
            ),
            array(
                'MAILTO' => 'test2@test.com'
            )
        );

        $comments = array(
            "Some comment before variables\nAnd some after",
            "",
            "------------ CURRENTLY MANAGED by Test --------------\n" .
            "Rule below is managed by CrontabLibrary by Hexmedia - Do not modify it!  0cbc6611f502690a30dc24bcc1148cfa",
            "Rule below is managed by CrontabLibrary by Hexmedia - Do not modify it!  0cbc6611f5f04eb5607f81bdf9c11ffe\n" .
            "Send to test1\n" .
            "Or not...   //only the second one will be saved :)"
        );

        for ($i = 0; $i < 4; $i++) {
            $parsed[$i]->shouldHaveCount(9);

            $parsed[$i]['command']->shouldReturn($commands[$i]);
            $parsed[$i]['log_file']->shouldReturn(sprintf("./logs/schema_validate%d.log", $i + 1));
            $parsed[$i]['minute']->shouldReturn($minutes[$i]);
            $parsed[$i]['hour']->shouldReturn($hours[$i]);
            $parsed[$i]['day_of_week']->shouldReturn($dayOfWeek[$i]);
            $parsed[$i]['day_of_month']->shouldReturn($dayOfMonth[$i]);
            $parsed[$i]['month']->shouldReturn($month[$i]);
            $parsed[$i]['variables']->shouldReturn($variables[$i]);
            $parsed[$i]['comment']->shouldReturn($comments[$i]);
        }
    }
}
