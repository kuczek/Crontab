<?php
/**
 * @copyright 2014-2016 hexmedia.pl
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 */

namespace spec\Hexmedia\Crontab\System;

use Hexmedia\Crontab\Exception\SystemOperationException;
use Hexmedia\Crontab\System\Unix;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use Prophecy\Argument;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class SaverToolSpec
 * @package spec\Hexmedia\Crontab\Writer\System\Unix
 *
 * This class cannot be tested without calling real save.
 */
class UnixSpec extends ObjectBehavior
{
    function let(ProcessBuilder $processBuilder, Process $process)
    {
        $processBuilder->setPrefix("crontab")->willReturn($processBuilder);
        $processBuilder->getProcess()->willReturn($process);
        $process->run()->willReturn(true);

        $this::setProcessBuilder($processBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Hexmedia\Crontab\System\Unix');
    }

    function it_can_check_if_it_is_unix()
    {
        if (PHP_OS === "Linux" || PHP_OS === "FreeBSD") {
            $this::isUnix()->shouldReturn(true);
        } else {
            $this::isUnix()->shouldReturn(false);
        }
    }

    function it_is_allowed_to_get($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-l"))->willReturn($processBuilder);
        $process->run()->willReturn(null);
        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn("#some response");
        $this::get()->shouldReturn("#some response");
    }

    function it_is_not_allowed_to_get_for_wrong_user($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-l", "-u", "sdg4o"))->willReturn($processBuilder);
        $process->getErrorOutput()->willReturn("crontab:  user `sdg4o' unknown");
        $process->getOutput()->shouldNotBeCalled();
        $process->run()->wilLReturn(true);
        $this
            ->shouldThrow(new SystemOperationException("Executing error: crontab:  user `sdg4o' unknown"))
            ->during('get', array("sdg4o"));
    }

    function it_is_returning_false_when_there_is_no_crontab_for_user($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-l"))->willReturn($processBuilder);
        $process->run()->willReturn(null);
        $process->getErrorOutput()->willReturn("no crontab for user kkuczek");
        $process->getOutput()->shouldNotBeCalled();
        $this::get()->shouldReturn(false);
    }


    function it_is_allowing_to_save($processBuilder, $process)
    {
        $content = "#TEST";
        $processBuilder->setArguments(Argument::that(function ($argument) use ($content) {
            return
                1 === sizeof($argument)
                && 0 == strpos("/tmp/", $argument[0])
                //Checking content of temporary file;
                && file_exists($argument[0])
                && file_get_contents($argument[0]) === $content;
        }))->willReturn($processBuilder); //Maybe we should do better test here

        $process->run()->willReturn(true);

        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn('');

        $this::save($content)->shouldReturn(true);
    }

    function it_throws_exception_when_unknown_output($processBuilder, $process)
    {
        $content = "#TEST";
        $processBuilder->setArguments(Argument::that(function ($argument) use ($content) {
            return
                1 === sizeof($argument)
                && 0 == strpos("/tmp/", $argument[0])
                //Checking content of temporary file;
                && file_exists($argument[0])
                && file_get_contents($argument[0]) === $content;
        }))->willReturn($processBuilder); //Maybe we should do better test here

        $process->run()->willReturn(true);

        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn('some error');

        $this->shouldThrow(new SystemOperationException("Unexpected output: some error"))
            ->duringSave($content);
    }

    function it_is_not_allowing_to_save_unknown_user($processBuilder, $process)
    {
        $content = "# some content";

        $processBuilder->setArguments(Argument::that(function ($argument) use ($content) {
            return
                3 === sizeof($argument)
                && "-u" === $argument[0]
                && "sdg4o" === $argument[1]
                && 0 == strpos("/tmp/", $argument[2])
                //Checking content of temporary file;
                && file_exists($argument[2])
                && file_get_contents($argument[2]) === $content;
        }))->willReturn($processBuilder);

        $process->getErrorOutput()->willReturn("crontab:  user `sdg4o' unknown");

        $this
            ->shouldThrow(new SystemOperationException("Executing error: crontab:  user `sdg4o' unknown"))
            ->during('save', array($content, 'sdg4o'));
    }

    function it_is_allowed_to_clear_whole_crontab($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-r"))->willReturn($processBuilder);
        $process->getErrorOutput()->willReturn(false);
        $process->getOutput()->willReturn('');

        $this::clear();
    }

    function it_is_not_allowed_to_clear_for_unexisting_user($processBuilder, $process)
    {
        $processBuilder->setArguments(array('-u', 'sdg4o', '-r'))->willReturn($processBuilder);
        $process->getErrorOutput()->willReturn("crontab:  user `sdg4o' unknown");

        $process->run()->willReturn('');
        $this
            ->shouldThrow(new SystemOperationException("Executing error: crontab:  user `sdg4o' unknown"))
            ->during('clear', array('sdg4o'));
    }

    function it_is_returning_true_when_trying_to_clear_cleared_crontab($processBuilder, $process)
    {
        $processBuilder->setArguments(array('-r'))->willReturn($processBuilder);
        $process->getErrorOutput()->willReturn("no crontab for user a");
        $process->getOutput()->shouldNotBeCalled();

        $this::clear()->shouldReturn(true);
    }

    function it_throws_exception_when_clear_will_return_unexpected_output($processBuilder, $process)
    {
        $content = "#TEST";
        $processBuilder->setArguments(array("-r"))->willReturn($processBuilder); //Maybe we should do better test here

        $process->run()->willReturn(true);

        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn('some error');

        $this->shouldThrow(new SystemOperationException("Unexpected output: some error"))
            ->duringClear();
    }

    function it_has_default_temporary_directory()
    {
        $this::getTemporaryDir()->shouldReturn(sys_get_temp_dir());
    }

    function it_is_able_to_set_temporary_directory()
    {
        $this::setTemporaryDir("/tmp2");
        $this::getTemporaryDir()->shouldReturn("/tmp2");
        $this::setTemporaryDir(null);
        $this::getTemporaryDir()->shouldReturn(sys_get_temp_dir());
    }

    function it_allows_to_check_if_its_unix()
    {
        $isUnix = $this::isUnix();

        if ("Linux" === PHP_OS || "FreeBSD" === PHP_OS) {
            $isUnix->shouldReturn(true);
        } else {
            $isUnix->shouldReturn(false);
        }
    }

    function it_allows_to_get_all_supported_os()
    {
        $this::getUnixList()->shouldHaveCount(2);
    }

    function it_allows_to_add_supported_os()
    {
        $this::addUnix("OsX")->shouldReturn(true);

        $this::getUnixList()->shouldHaveCount(3);
    }

    function it_allows_to_remove_supported_os()
    {
        $this::removeUnix("OsX")->shouldReturn(true);

        $this::getUnixList()->shouldHaveCount(2);
    }

    function it_do_not_allows_to_remove_unexisting_supported_os()
    {
        $this::removeUnix("WinNT")->shouldReturn(false);

        $this::getUnixList()->shouldHaveCount(2);
    }

    function it_allows_to_set_temporary_dir()
    {
        $dir = "/var/tmp";
        $this::setTemporaryDir($dir);
        $this::getTemporaryDir()->shouldReturn($dir);
    }

    function it_allows_to_check_if_crontab_is_setup($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-l"))->willReturn($processBuilder);
        $process->run()->willReturn(null);
        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn("#some response");
        $this::isSetUp()->shouldReturn(true);
    }

    function it_allows_to_check_if_crontab_is_not_setup($processBuilder, $process)
    {
        $processBuilder->setArguments(array("-l"))->willReturn($processBuilder);
        $process->run()->willReturn(null);
        $process->getErrorOutput()->willReturn(null);
        $process->getOutput()->willReturn(false);
        $this::isSetUp()->shouldReturn(false);
    }
}
