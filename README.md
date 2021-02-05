# Crystal-RSS

[![Build Status](https://travis-ci.org/Kaishiyoku/Crystal-RSS.svg?branch=master)](https://travis-ci.org/Kaishiyoku/Crystal-RSS)

Simple web-based RSS feed reader.

<p align="center">
 <img src="https://crystal-rss.rocks/img/logo.svg" alt="Logo" width="125"/>
</p>

Table of contents
=================
  * [Upgrade notices](#upgrade-notices)
  * [Installation](#installation)
  * [Screenshots](#screenshots)
  * [License](#license)
  * [Author](#author)

Upgrade notices
===============

Upgrading from 2.* to 3.*
-------------------------
During the migration process all values of the columns `content` and `raw_json` of the `feed_items` table are being copied to a new table `feed_item_details` and then deleted from the `feed_items` table.

*Please make a backup copy of the `feed_items` table.*

No other breaking changes were introduced.

Upgrading from 1.8.* to 2.0.*
-----------------------------
During the migration process all entries of the `feed_item_feed_item_category` table are being deleted.
If you want to keep the data please export them as SQL statements first, so you can re-import them after migration is finished. 

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

Screenshots
===========
https://imgur.com/a/DWPNn47

|                                                              |                                                              |
|--------------------------------------------------------------|--------------------------------------------------------------|
| ![Feed with items](https://i.imgur.com/Azv6eUS.png?raw=true) | ![Search](https://i.imgur.com/kD5T53C.png?raw=true)          |
| ![Statistics](https://i.imgur.com/ICdkbS7.png?raw=true)      | ![Article details](https://i.imgur.com/nzfbnj4.png?raw=true) |

License
=======
MIT (https://github.com/Kaishiyoku/Crystal-RSS/blob/master/LICENSE)


Author
======
Twitter: [@kaishiyoku](https://twitter.com/kaishiyoku)  
Website: www.andreas-wiedel.de
