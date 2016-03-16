Tests:
------
* Configure at least one osx(travis) environment to test if it is working on osx.

This version
------------
* System reader should also use factory.
* Readers needs to be checked and refactored
* Check names of all systems that should be supported. All Unix like.
* Add specs to existing commands
* Try integration with Symfony CrontabBundle. This will need some commands to be rewritten
* Unify exception names.
* Change beforeComment to comment
* Add protection for special strings in unix, if they exists, this should not work.

Next Versions
-------------
* support for special strings in unix cron, and possibility to setup cron for startup.
* support for comments in variables, currently, all comments between variables will be ignored, and removed.
* add support for importing tasks from crontab to file, should be interactive command.

In future
---------
* support for windows Tasks (more info: http://stackoverflow.com/questions/132971/what-is-the-windows-version-of-cron, https://msdn.microsoft.com/en-us/library/windows/desktop/bb736357(v=vs.85).aspx)
