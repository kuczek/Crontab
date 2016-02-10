This version
------------
* Rewrite all parser to support content not file /be consistent/.
* System reader should also use factory.
* Task needs to be cleared and phpspeced
* Read should be done always via System/*.php (eg. for Unix System/Unix.php)
* Configure at least one osx(travis) environment to test if it is working on osx.
* Check names of all systems that should be supported. All Unix like.
* Add phpspec to existing commands
* Try integration with Symfony CrontabBundle. This will need some commands to be rewritten

Next Versions
------------
* support for windows Tasks (more info: http://stackoverflow.com/questions/132971/what-is-the-windows-version-of-cron)
* support for special strings in unix cron (only reading will be enough i think), and possibility to setup cron for startup.
* create comment object that can be added to task or variable
* support for comments in variables, currently, all comments between variables will be ignored, and removed.
* Why appveyor is not resulting in error after runing travis
* add support for importing tasks from crontab to file, should be interactive command.
