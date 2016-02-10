Crontab
=======
[![Build Status](https://travis-ci.org/Hexmedia/Crontab.svg?branch=master)](https://travis-ci.org/Hexmedia/Crontab) [![Build Status](https://ci.appveyor.com/api/projects/status/github/Hexmedia/crontab?branch=master&svg=true)](https://ci.appveyor.com/project/kuczek/crontab/history) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/bb22e198-7f34-4a13-a70c-03442493f827/mini.png)](https://insight.sensiolabs.com/projects/bb22e198-7f34-4a13-a70c-03442493f827) [![Coverage Status](https://coveralls.io/repos/github/Hexmedia/Crontab/badge.svg?branch=master)](https://coveralls.io/github/Hexmedia/Crontab?branch=master)
[![Latest Stable Version](https://poser.pugx.org/hexmedia/crontab/v/stable)](https://packagist.org/packages/hexmedia/crontab) [![Total Downloads](https://poser.pugx.org/hexmedia/crontab/downloads)](https://packagist.org/packages/hexmedia/crontab) [![Latest Unstable Version](https://poser.pugx.org/hexmedia/crontab/v/unstable)](https://packagist.org/packages/hexmedia/crontab) [![License](https://poser.pugx.org/hexmedia/crontab/license)](https://packagist.org/packages/hexmedia/crontab)

Library for managing crontab on your system.
Currently supports only FreeBSD and Linux devices, for other devices see section: [Other Unix Like crontab systems](#other-unix-like-crontab-systems)

Installation
------------

### Phar file
add instruction

### Global composer
composer.phar global require hexmedia/crontab

### For project
composer.phar require hexmedia/crontab

Usage
-----

### Other Unix Like crontab systems
If your system is not identified as Linux or FreeBSD, you can easily add support for them by adding this code to
your application:
```
Hexmedia\Crontab\Reader\SystemUnixReader::addSupportedOs("FreeBSD");
```

Known problems
--------------

* Does not support special crontab values like @daily, @yearly
* Does not support correctly comments between variables
