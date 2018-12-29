# Change Log

## [0.14.0](https://github.com/kaishiyoku/crystal-rss/tree/0.14.0) (2018-12-29)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.13.0...0.14.0)

**Implemented enhancements:**

- Rework up- and downvoting UI in react [\#94](https://github.com/Kaishiyoku/Crystal-RSS/issues/94)
- Add API token generation upon user registration [\#92](https://github.com/Kaishiyoku/Crystal-RSS/issues/92)
- Change order of last update log item [\#91](https://github.com/Kaishiyoku/Crystal-RSS/issues/91)

**Fixed bugs:**

- Fix English navigation translation for the update errors link [\#93](https://github.com/Kaishiyoku/Crystal-RSS/issues/93)

## [0.13.0](https://github.com/kaishiyoku/crystal-rss/tree/0.13.0) (2018-12-23)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.12.0...0.13.0)

**Implemented enhancements:**

- Adjust calculation of the average time to read an article as read: only take the last month [\#89](https://github.com/Kaishiyoku/Crystal-RSS/issues/89)
- Adjust feed list for mobile devices [\#88](https://github.com/Kaishiyoku/Crystal-RSS/issues/88)
- Add ability to up- and downvote feed items [\#87](https://github.com/Kaishiyoku/Crystal-RSS/issues/87)
- Upgrade to Bootstrap 4.2 [\#86](https://github.com/Kaishiyoku/Crystal-RSS/issues/86)
- Adjust theme [\#85](https://github.com/Kaishiyoku/Crystal-RSS/issues/85)
- Add ability to read update errors [\#83](https://github.com/Kaishiyoku/Crystal-RSS/issues/83)
- Add date range filter for search [\#82](https://github.com/Kaishiyoku/Crystal-RSS/issues/82)

**Fixed bugs:**

- No redirect to index page when marking all items of a specific category as read by using the checkboxes [\#81](https://github.com/Kaishiyoku/Crystal-RSS/issues/81)

**Closed issues:**

- Update Composer dependencies [\#84](https://github.com/Kaishiyoku/Crystal-RSS/issues/84)

## [0.12.0](https://github.com/kaishiyoku/crystal-rss/tree/0.12.0) (2018-12-14)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.11.0...0.12.0)

**Implemented enhancements:**

- Add better error messages to the error log table [\#80](https://github.com/Kaishiyoku/Crystal-RSS/issues/80)
- Add ability to filter search by feed [\#77](https://github.com/Kaishiyoku/Crystal-RSS/issues/77)
- Add ability to optionally give a category a color [\#74](https://github.com/Kaishiyoku/Crystal-RSS/issues/74)

**Fixed bugs:**

- Some feed items couldn't be added to the database due to the author field being not long enough [\#79](https://github.com/Kaishiyoku/Crystal-RSS/issues/79)
- Can't add the same feed items for multiple users due to user-independent duplicate check [\#78](https://github.com/Kaishiyoku/Crystal-RSS/issues/78)
- Search field is empty after submitting it [\#76](https://github.com/Kaishiyoku/Crystal-RSS/issues/76)
- The optional color field raises a validation exception when it is empty [\#75](https://github.com/Kaishiyoku/Crystal-RSS/issues/75)

## [0.11.0](https://github.com/kaishiyoku/crystal-rss/tree/0.11.0) (2018-12-13)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.10.1...0.11.0)

**Implemented enhancements:**

- Add ability to optionally give a feed a color [\#72](https://github.com/Kaishiyoku/Crystal-RSS/issues/72)
- Add simple statistics about when articles were published and read [\#71](https://github.com/Kaishiyoku/Crystal-RSS/issues/71)

**Closed issues:**

- Optimize feed page database queries [\#73](https://github.com/Kaishiyoku/Crystal-RSS/issues/73)

## [0.10.1](https://github.com/kaishiyoku/crystal-rss/tree/0.10.1) (2018-12-03)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.10.0...0.10.1)

**Fixed bugs:**

- Issue when formatting the "read\_at" field of a feed item [\#70](https://github.com/Kaishiyoku/Crystal-RSS/issues/70)

## [0.10.0](https://github.com/kaishiyoku/crystal-rss/tree/0.10.0) (2018-11-26)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.9.1...0.10.0)

**Implemented enhancements:**

- Add default category for newly registered user [\#67](https://github.com/Kaishiyoku/Crystal-RSS/issues/67)
- Add user creation Artisan command [\#66](https://github.com/Kaishiyoku/Crystal-RSS/issues/66)
- Use more considerable "no unread articles" visualization [\#65](https://github.com/Kaishiyoku/Crystal-RSS/issues/65)
- Add feed item categories [\#64](https://github.com/Kaishiyoku/Crystal-RSS/issues/64)
- Show details of feed items for administrators [\#63](https://github.com/Kaishiyoku/Crystal-RSS/issues/63)
- Store all other xml fields of a feed item in the database [\#62](https://github.com/Kaishiyoku/Crystal-RSS/issues/62)

**Fixed bugs:**

- Sort search results by date [\#60](https://github.com/Kaishiyoku/Crystal-RSS/issues/60)

**Closed issues:**

- Update Composer dependencies [\#69](https://github.com/Kaishiyoku/Crystal-RSS/issues/69)
- Update npm dependencies [\#68](https://github.com/Kaishiyoku/Crystal-RSS/issues/68)
- Add some screenshots to readme [\#61](https://github.com/Kaishiyoku/Crystal-RSS/issues/61)

## [0.9.1](https://github.com/kaishiyoku/crystal-rss/tree/0.9.1) (2018-11-15)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.9.0...0.9.1)

**Fixed bugs:**

- MySQL Exception when feed item data too long [\#59](https://github.com/Kaishiyoku/Crystal-RSS/issues/59)

## [0.9.0](https://github.com/kaishiyoku/crystal-rss/tree/0.9.0) (2018-11-15)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.8.0...0.9.0)

**Implemented enhancements:**

- Add hover background effect to the article list [\#57](https://github.com/Kaishiyoku/Crystal-RSS/issues/57)
- Add ability to hide link to Laravel Telescope by using a .env variable [\#52](https://github.com/Kaishiyoku/Crystal-RSS/issues/52)
- Add link to Laravel Telescope for administrators [\#51](https://github.com/Kaishiyoku/Crystal-RSS/issues/51)
- Add link to Laravel Horizon for administrators [\#49](https://github.com/Kaishiyoku/Crystal-RSS/issues/49)

**Fixed bugs:**

- When marking all articles of a certain category as read the user is being redirected with that category id set [\#54](https://github.com/Kaishiyoku/Crystal-RSS/issues/54)
- Wrong date format for German locale [\#50](https://github.com/Kaishiyoku/Crystal-RSS/issues/50)

**Closed issues:**

- Upgrade npm dependencies [\#58](https://github.com/Kaishiyoku/Crystal-RSS/issues/58)
- Adjust HTTP error pages [\#56](https://github.com/Kaishiyoku/Crystal-RSS/issues/56)
- Upgrade Composer dependencies [\#55](https://github.com/Kaishiyoku/Crystal-RSS/issues/55)
- Add information about installing Crystal RSS under Windows due to the addition of Laravel Horizon [\#53](https://github.com/Kaishiyoku/Crystal-RSS/issues/53)

## [0.8.0](https://github.com/kaishiyoku/crystal-rss/tree/0.8.0) (2018-11-14)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.7.1...0.8.0)

**Implemented enhancements:**

- Adjust logo [\#48](https://github.com/Kaishiyoku/Crystal-RSS/issues/48)
- Add German localization [\#47](https://github.com/Kaishiyoku/Crystal-RSS/issues/47)
- Add ability to change email address [\#46](https://github.com/Kaishiyoku/Crystal-RSS/issues/46)
- Add Laravel Horizon [\#45](https://github.com/Kaishiyoku/Crystal-RSS/issues/45)

## [0.7.1](https://github.com/kaishiyoku/crystal-rss/tree/0.7.1) (2018-11-09)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.7.0...0.7.1)

**Implemented enhancements:**

- Mark all as read: Only defer when there are more than 1000 items to update [\#43](https://github.com/Kaishiyoku/Crystal-RSS/issues/43)

**Fixed bugs:**

- History is sorted in the wrong direction [\#42](https://github.com/Kaishiyoku/Crystal-RSS/issues/42)
- Link to profile missing [\#41](https://github.com/Kaishiyoku/Crystal-RSS/issues/41)

**Closed issues:**

- Refactor translation function calls [\#44](https://github.com/Kaishiyoku/Crystal-RSS/issues/44)

## [0.7.0](https://github.com/kaishiyoku/crystal-rss/tree/0.7.0) (2018-11-08)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.6.0...0.7.0)

**Implemented enhancements:**

- Feed favicons [\#4](https://github.com/Kaishiyoku/Crystal-RSS/issues/4)
- Add RSS fetching duration to UpdateLog [\#37](https://github.com/Kaishiyoku/Crystal-RSS/issues/37)
- Add Laravel Backup [\#36](https://github.com/Kaishiyoku/Crystal-RSS/issues/36)
- Add ability to change password [\#35](https://github.com/Kaishiyoku/Crystal-RSS/issues/35)

**Fixed bugs:**

- Server error when retrieving too many feed items [\#17](https://github.com/Kaishiyoku/Crystal-RSS/issues/17)
- Timeout when clicking "Mark all as read" and there are many unread articles [\#39](https://github.com/Kaishiyoku/Crystal-RSS/issues/39)
- Oldest update log is being fetched instead of newest one [\#34](https://github.com/Kaishiyoku/Crystal-RSS/issues/34)
- Exception when there is no update log yet [\#33](https://github.com/Kaishiyoku/Crystal-RSS/issues/33)

**Closed issues:**

- Remove unnecessary field "is\_read" from feed\_items table [\#40](https://github.com/Kaishiyoku/Crystal-RSS/issues/40)
- Update Composer dependencies [\#38](https://github.com/Kaishiyoku/Crystal-RSS/issues/38)
- Add installation instructions [\#15](https://github.com/Kaishiyoku/Crystal-RSS/issues/15)

## [0.6.0](https://github.com/kaishiyoku/crystal-rss/tree/0.6.0) (2018-10-27)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.5.0...0.6.0)

**Implemented enhancements:**

- Add ability to disable feeds [\#32](https://github.com/Kaishiyoku/Crystal-RSS/issues/32)
- Hide categories with no unread feed items [\#30](https://github.com/Kaishiyoku/Crystal-RSS/issues/30)
- Adjust theme [\#29](https://github.com/Kaishiyoku/Crystal-RSS/issues/29)
- Use checkboxes for marking feed items as read instead of a single-action button [\#27](https://github.com/Kaishiyoku/Crystal-RSS/issues/27)
- Show timestamp of the last feed update [\#26](https://github.com/Kaishiyoku/Crystal-RSS/issues/26)

**Closed issues:**

- Add Laravel Telescope [\#31](https://github.com/Kaishiyoku/Crystal-RSS/issues/31)
- Adjust theme [\#28](https://github.com/Kaishiyoku/Crystal-RSS/issues/28)

## [0.5.0](https://github.com/kaishiyoku/crystal-rss/tree/0.5.0) (2018-10-26)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.4.0...0.5.0)

**Implemented enhancements:**

- Upgrade to Laravel 5.7 [\#25](https://github.com/Kaishiyoku/Crystal-RSS/issues/25)
- Use pagination instead of "more" button [\#23](https://github.com/Kaishiyoku/Crystal-RSS/issues/23)
- Upgrade to Laravel 5.6 [\#19](https://github.com/Kaishiyoku/Crystal-RSS/issues/19)
- Switch to Material UI [\#16](https://github.com/Kaishiyoku/Crystal-RSS/issues/16)
- Replace Object.assign with \_.merge [\#13](https://github.com/Kaishiyoku/Crystal-RSS/issues/13)
- CRY-18 closed \#18 switched back to classic templates without React [\#20](https://github.com/Kaishiyoku/Crystal-RSS/pull/20) ([Kaishiyoku](https://github.com/Kaishiyoku))

**Closed issues:**

- Remove "Update feed" button [\#24](https://github.com/Kaishiyoku/Crystal-RSS/issues/24)
- Add search again [\#21](https://github.com/Kaishiyoku/Crystal-RSS/issues/21)
- Switch back to classic templates without React [\#18](https://github.com/Kaishiyoku/Crystal-RSS/issues/18)

**Merged pull requests:**

- Switch back to classic templates without React \(part 2\) [\#22](https://github.com/Kaishiyoku/Crystal-RSS/pull/22) ([Kaishiyoku](https://github.com/Kaishiyoku))

## [0.4.0](https://github.com/kaishiyoku/crystal-rss/tree/0.4.0) (2017-09-28)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.3.0...0.4.0)

**Implemented enhancements:**

- Optimize JSON response data file size [\#14](https://github.com/Kaishiyoku/Crystal-RSS/issues/14)
- Information about when a feed item has been read [\#12](https://github.com/Kaishiyoku/Crystal-RSS/issues/12)
- Implement search [\#11](https://github.com/Kaishiyoku/Crystal-RSS/issues/11)
- Switch to React [\#3](https://github.com/Kaishiyoku/Crystal-RSS/issues/3)

## [0.3.0](https://github.com/kaishiyoku/crystal-rss/tree/0.3.0) (2017-09-17)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.2.2...0.3.0)

## [0.2.2](https://github.com/kaishiyoku/crystal-rss/tree/0.2.2) (2017-09-04)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.2.1...0.2.2)

**Fixed bugs:**

- Google alert RSS feeds not being fetched properly [\#10](https://github.com/Kaishiyoku/Crystal-RSS/issues/10)
- Pagination at unread feed items not working as expected [\#9](https://github.com/Kaishiyoku/Crystal-RSS/issues/9)

## [0.2.1](https://github.com/kaishiyoku/crystal-rss/tree/0.2.1) (2017-09-03)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.2.0...0.2.1)

**Implemented enhancements:**

- Better pagination [\#7](https://github.com/Kaishiyoku/Crystal-RSS/issues/7)

## [0.2.0](https://github.com/kaishiyoku/crystal-rss/tree/0.2.0) (2017-09-02)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.1.1...0.2.0)

**Implemented enhancements:**

- Upgrade to Laravel 5.5 [\#6](https://github.com/Kaishiyoku/Crystal-RSS/issues/6)
- Paginated content [\#5](https://github.com/Kaishiyoku/Crystal-RSS/issues/5)
- Categories [\#2](https://github.com/Kaishiyoku/Crystal-RSS/issues/2)

## [0.1.1](https://github.com/kaishiyoku/crystal-rss/tree/0.1.1) (2017-08-28)
[Full Changelog](https://github.com/kaishiyoku/crystal-rss/compare/0.1.0...0.1.1)

**Implemented enhancements:**

- Breadcrumbs [\#1](https://github.com/Kaishiyoku/Crystal-RSS/issues/1)

## [0.1.0](https://github.com/kaishiyoku/crystal-rss/tree/0.1.0) (2017-08-27)


\* *This Change Log was automatically generated by [github_changelog_generator](https://github.com/skywinder/Github-Changelog-Generator)*