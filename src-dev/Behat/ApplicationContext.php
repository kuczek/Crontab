<?php
/**
 * @author    Krystian Kuczek <krystian@hexmedia.pl>
 * @copyright 2013-2016 Hexmedia.pl
 * @license   @see LICENSE
 */

namespace dev\Hexmedia\Crontab\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Hexmedia\Crontab\Application;
use Hexmedia\Crontab\System\Unix;
use Hexmedia\Symfony\FakeProcess\FakeProcessBuilder;
use PhpSpec\Matcher\MatchersProviderInterface;
use Symfony\Component\Console\Tester\ApplicationTester;
use PHPUnit_Framework_Assert as Assertions;

/**
 * Class CommandFeatureContext
 *
 * @package dev\Hexmedia\Crontab\Behat
 */
class ApplicationContext implements Context, MatchersProviderInterface, SnippetAcceptingContext
{

    /**
     * @var ApplicationTester
     */
    private $tester;

    /**
     * @var Application
     */
    private $application;

    /**
     * @var int
     */
    private $lastExitCode;

    /**
     * @var string
     */
    private $lastDisplay;

    /**
     * @var FakeProcessBuilder
     */
    private $processBuilder;

    /**
     * @var string
     */
    private $currentCrontab;

    /**
     * @return array
     */
    public function getMatchers()
    {
        return array();
    }

    /**
     * @beforeScenario
     */
    public function initApplication()
    {
        $this->application = new Application();

        $this->application->setAutoExit(false);

        $this->tester = new ApplicationTester($this->application);
    }

    /**
     * @param string       $command
     * @param string       $file
     * @param PyStringNode $options
     *
     * @When /^I run (?P<command>[a-zA-Z0-9\.\:]*) command with file \"(?P<file>[^\"]*)\"$/
     * @When /^I run (?P<command>[a-zA-Z0-9\.\:]*) command with file \"(?P<file>[^\"]*)\" and options:$/
     */
    public function iRunCommand($command, $file = null, PyStringNode $options = null)
    {
        $arguments = array(
            'command' => $command,
            'name' => 'Test',
        );

        $arguments['configuration-file'] = __DIR__ . "/../../" . $file;

        if (null != $options) {
            $options = $this->parseOptions($options);

            $arguments += $options;
        }

        $runOptions = array('interactive' => false, 'decorated' => false);

        $this->lastExitCode = $this->tester->run($arguments, $runOptions);
        $this->lastDisplay = $this->tester->getDisplay();
    }

    /**
     * @param int $response
     *
     * @throws \Exception
     *
     * @Then /The exit code should be (\d+)/
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function theExitCodeShouldBe($response)
    {
        if ((int) $response !== $this->lastExitCode) {
            throw new \Exception($this->lastDisplay);
        }

        Assertions::assertSame((int) $response, $this->lastExitCode);
    }

    /**
     * @param PyStringNode $content
     *
     * @Then Crontab should contain:
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function crontabShouldContain(PyStringNode $content)
    {
        $crontab = $this->currentCrontab;

        Assertions::assertNotFalse($crontab);

        if ("" == $content->getRaw()) {
            Assertions::assertEquals("", $crontab);
        } else {
            Assertions::assertContains($content->getRaw(), $crontab);
        }
    }

    /**
     * @param PyStringNode $content
     *
     * @Then Crontab should be:
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function crontabShouldBe(PyStringNode $content)
    {
        $crontab = $this->currentCrontab;

        Assertions::assertNotFalse($crontab);

        if ("" == $content->getRaw()) {
            Assertions::assertEquals("", $crontab);
        } else {
            Assertions::assertEquals($content->getRaw(), $crontab);
        }
    }

    /**
     * @param PyStringNode $display
     *
     * @Then The display should be:
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function theDisplayShouldBe(PyStringNode $display)
    {
        Assertions::assertSame($display->getRaw(), $this->lastDisplay);
    }

    /**
     * @param PyStringNode $display
     *
     * @Then The display should contain:
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function theDisplayShouldContain(PyStringNode $display)
    {
        Assertions::assertContains($display->getRaw(), $this->lastDisplay);
    }

    /**
     * @Then The display should be empty
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function theDisplayShouldBeEmpty()
    {
        Assertions::assertEquals('', $this->lastDisplay);
    }

    /**
     * @Given The process builder is fake
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function theProcessBuilderIsFake()
    {
        $this->processBuilder = new FakeProcessBuilder();

        Unix::setProcessBuilder($this->processBuilder);
    }

    /**
     * @Given /^\"(?P<command>[^\"]*)\" command will have (?P<code>\d+) as exit code$/
     * @Given /^\"(?P<command>[^\"]*)\" command will have (?P<code>\d+) as exit code and will return:/
     *
     * @param string       $command
     * @param string       $code
     * @param PyStringNode $string
     */
    public function commandWillHaveAsExitCodeAndWillReturn($command, $code, PyStringNode $string = null)
    {
        $this->processBuilder->addCommand(
            $command,
            function ($command) use ($string) {
                if (null !== $string) {
                    return $string->getRaw();
                }

                return '';
            },
            $code
        );
    }

    /**
     * @Given Crontab save will be called
     */
    public function crontabSaveShouldBeCalled()
    {
        $command = "'crontab' '/tmp/.*'";

        $content = '';
        $this->currentCrontab = &$content;
        $content = '1';

        $this->processBuilder->addCommand(
            $command,
            function ($command) use (&$content) {
                if (preg_match("#'crontab' '(/tmp/.*)'#", $command, $matches)) {
                    $content = file_get_contents($matches[1]);
                }
            },
            0
        );
    }

    /**
     * @param PyStringNode $options
     *
     * @return array
     */
    private function parseOptions(PyStringNode $options)
    {
        $return = array();

        foreach ($options->getStrings() as $option) {
            if (preg_match('/(?P<option>\-\-[a-zA-Z0-9\-]*)((\=|\s)(?P<value>[^\n\s]*))?/', $option, $matches)) {
                $return[$matches['option']] = isset($matches['value']) ? $matches['value'] : true;
            }

            if (preg_match('/(?P<option>\-[a-zA-Z0-9\-]*) (?P<value>[^\n\s]*)?/', $option, $matches)) {
                $return[$matches['option']] = isset($matches['value']) ? $matches['value'] : true;
            }
        }

        return $return;
    }

}
