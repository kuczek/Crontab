Feature: Synchronization of crontab
  As a Developer
  I want to synchronize my cron with application configuration

  Background:
    Given The process builder is fake
    And Crontab save will be called

  Scenario Outline: Synchronizing with different types
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>" and options:
      """
      -t <type>
      """
    Then The exit code should be 0
    And The display should contain:
      """
      Your crontab has been updated!
      """
    And Crontab should be:
      """
      #WARNING!!!
      #This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
      #EOT


      */10 * * * *       test

      # ------------ CURRENTLY MANAGED by Test --------------

      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5341b9a85da40865f5647c
      #
      MAILTO=test@test.pl
      */13 * * * *       ./some/command1 > ./logs/some_log1.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5f6034d349bc599edc77a3
      #
      MAILTO=test@test.com
      NO_VALIDATE=1
      * * * * *       ./some/command2 > ./logs/some_log2.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f563c3f5f02e473809fe5c1
      #
      * * * * *       ./some/command_without_log_file

      """

    Examples:
      | type | ext  |
      | ini  | ini  |
      | yaml | yml  |
      | xml  | xml  |
      | json | json |
      | yml  | yml  |

  Scenario Outline: Working without crontab
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>" and options:
      """
      -t <type>
      """
    Then The exit code should be 0
    And The display should contain:
      """
      Your crontab has been updated!
      """
    And Crontab should be:
      """
      #WARNING!!!
      #This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
      #EOT



      # ------------ CURRENTLY MANAGED by Test --------------

      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5341b9a85da40865f5647c
      #
      MAILTO=test@test.pl
      */13 * * * *       ./some/command1 > ./logs/some_log1.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5f6034d349bc599edc77a3
      #
      MAILTO=test@test.com
      NO_VALIDATE=1
      * * * * *       ./some/command2 > ./logs/some_log2.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f563c3f5f02e473809fe5c1
      #
      * * * * *       ./some/command_without_log_file

      """

    Examples:
      | type | ext  |
      | ini  | ini  |
      | yaml | yml  |
      | xml  | xml  |
      | json | json |
      | yml  | yml  |

  Scenario: It is not updating when there are no managed
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/empty.xml" and options:
      """
      --type=xml
      """
    Then The exit code should be 0
    And The display should contain:
      """
      Your crontab does not need to be updated!

      """

  @not_ready
  Scenario: I run synchronize with unexisting file
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.dne" and options:
      """
      --type=xml
      """
    Then The exit code should be 1
    And The display should contain:
    """
    File "./Tests/example_configurations/test.dne" does not exists!
    """

    @test
  Scenario Outline: I run synchronize with wrong type
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>" and options:
      """
      --type=<type>
      """
    Then The exit code should be 1
    And The display should contain:
      """
      ./Tests/example_configurations/test.<ext>' does not have --type=<type> or has error in formatting.
      """

    Examples:
      | type | ext  |
      | xml  | yml  |
      | ini  | xml  |
      | yml  | json |
      | json | ini  |

  @not_ready
  Scenario Outline:  I run synchronize without giving type
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>"
    Then The exit code should be 0
    And The display should contain:
      """
      Your crontab has been updated!
      """
    And Crontab should be:
      """
      #WARNING!!!
      #This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
      #EOT


      */10 * * * *       test

      # ------------ CURRENTLY MANAGED by Test --------------

      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5341b9a85da40865f5647c
      #
      MAILTO=test@test.pl
      */13 * * * *       ./some/command1 > ./logs/some_log1.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5f6034d349bc599edc77a3
      #
      MAILTO=test@test.com
      NO_VALIDATE=1
      * * * * *       ./some/command2 > ./logs/some_log2.log
      #DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f563c3f5f02e473809fe5c1
      #
      * * * * *       ./some/command_without_log_file

      """
    Examples:
      | ext  |
      | ini  |
      | yml  |
      | xml  |
      | json |
      | yml  |

  @not_ready @desc_not_ready
  Scenario: Dry run
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>" and options:
      """
      --dry-run
      """
    Then The exit code should be 0

  @not_ready @desc_not_ready
  Scenario: With username
    Given "'crontab' '-l'" command will have 0 as exit code and will return:
      """
      */10 * * * *       test

      """
    When I run synchronize command with file "./Tests/example_configurations/test.<ext>" and options:
      """
      --user=kuczek
      """
    Then The exit code should be 0

