# Crystal-RSS

[![Build Status](https://travis-ci.org/Kaishiyoku/Crystal-RSS.svg?branch=master)](https://travis-ci.org/Kaishiyoku/Crystal-RSS)

Simple web-based RSS feed reader.

<p align="center">
 <img src="https://main.andreas-wiedel.de/myfiles/other/crystal-rss/Crystal_RSS_Logo.svg" alt="Logo" width="125"/>
</p>

![Lettering](https://main.andreas-wiedel.de/myfiles/other/crystal-rss/Crystal_RSS_Lettering.svg)

Table of contents
=================
  * [License](#license)
  * [Installation](#installation)
  * [Author](#author)
  
Installation
============
1. Download the latest release: https://github.com/Kaishiyoku/Crystal-RSS/releases/latest
2. remove the `php artisan ide-helper` commands from the `composer.json` file
3. run composer install --no-dev --no-scripts (if you're installing under Windows add the `--ignore-platform-reqs` flag due to the use of Laravel Horizon which is incompatible with Windows)
4. run php artisan migrate
5. run npm install
6. run npm run prod
7. copy the `.env.example` file and fill in the necessary values:  
`@php -r \"file_exists('.env') || copy('.env.example', '.env');\"`
8. Setup the cronjob for the scheduler commands:  
```
$ sudo crontab -e -u www-data
```
Add the cronjob (please adjust the path if necessary):
```
* * * * * php /var/www/html/crystal-rss/artisan schedule:run >> /var/www/html/crystal-rss/storage/logs/scheduler.log 2>&1
```
  
License
=======
MIT (https://github.com/Kaishiyoku/Crystal-RSS/blob/master/LICENSE)


Author
======
Twitter: [@kaishiyoku](https://twitter.com/kaishiyoku)  
Website: www.andreas-wiedel.de
