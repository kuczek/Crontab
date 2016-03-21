Feature: Echoing crontab
  As a Developer
  I want to echo crontab from app
#
#  Scenario:
#    When I run echo command with ini type
#    Then The exit code should be 0
#    And The display should contain:
#    """
#Your crontab will look like:
##WARNING!!!
##This crontab file it at least partially managed by Crontab by Hexmedia, please check all restrictions that comes with that library at: https://github.com/Hexmedia/Crontab/blob/master/README.md
##EOT
#
#
#
## ------------ CURRENTLY MANAGED by Test --------------
#
##DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5341b9a85da40865f5647c
##
#MAILTO=test@test.pl
#*/13 * * * *       ./some/command1 > ./logs/some_log1.log
##DO NOT MODIFY! This task is managed by Crontab library by Hexmedia 0cbc6611f5f6034d349bc599edc77a3
##
#MAILTO=test@test.com
#NO_VALIDATE=1
#* * * * *       ./some/command2 > ./logs/some_log2.log
#    """
#
