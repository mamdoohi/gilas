-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2012 at 11:18 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+03:30";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gilas`
--
CREATE DATABASE `gilas` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gilas`;

-- --------------------------------------------------------

--
-- Table structure for table `gl_acos`
--

DROP TABLE IF EXISTS `gl_acos`;
CREATE TABLE IF NOT EXISTS `gl_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_aros`
--

DROP TABLE IF EXISTS `gl_aros`;
CREATE TABLE IF NOT EXISTS `gl_aros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `foreign_key` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_aros_acos`
--

DROP TABLE IF EXISTS `gl_aros_acos`;
CREATE TABLE IF NOT EXISTS `gl_aros_acos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aro_id` int(11) DEFAULT NULL,
  `aco_id` int(11) DEFAULT NULL,
  `_create` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_read` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_update` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  `_delete` varchar(2) COLLATE utf8_persian_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aco_id` (`aco_id`),
  KEY `aro_id` (`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_comments`
--

DROP TABLE IF EXISTS `gl_comments`;
CREATE TABLE IF NOT EXISTS `gl_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'id of comment for replying from users for example administrator reply a comment which posted from Mohammad and it will be show in a quote tag in below the parent comment \r\n default is set to 0 for the main(parent) comments',
  `content_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'first name of user who add the comment this field is for guest users who haven''t user account in site',
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'user email address',
  `website` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'web site address',
  `content` text COLLATE utf8_persian_ci COMMENT 'comment body',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'comment is published or not By default all comment is published => published = 1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `gl_comments`
--

INSERT INTO `gl_comments` (`id`, `parent_id`, `content_id`, `name`, `email`, `website`, `content`, `published`, `created`) VALUES
(1, 0, 1, 'محمد رزاقی', '1razzaghi@gmail.com', 'http://bigitblog.ir', 'این کار از گوگل بعید نبود\r\nشرکتی که تا این حد به راهکارهای تحت وب اهمیت میده رو نمیشد چیزی غیر از این ازش انتظار داشت\r\n:)', 0, '1391-04-12 11:14:40'),
(2, 6, 1, 'حمید ممدوحی', 'hamid.mamdoohi@gmail.com', 'http://mosafer-behesht.com', 'سلام محمد\r\nمی خواستم ببینم سیستم نظراتت درست کار میکنه و به آدرس پیشوند رو اضافه می کنه یا نه\r\n:)', 0, '1391-05-12 12:32:25'),
(3, 6, 1, 'مصطفی مهتر', '', '', 'سلام محمد\r\nمی خواستم ببینم اگه برای وبسایت پیشوند بذارم برنامه هم میذاره یا نه؟', 0, '1391-05-12 12:34:20'),
(6, 1, 1, 'تست', 'test@l.com', 'http://test.ir', 'سلام\r\nاین نظر برای تست کردن عملکرد تابع آدرس می باشد.', 0, '1391-05-14 09:45:18'),
(4, 0, 1, 'رامین یاسایی', 'ramin@gmail.com', 'http://novin-it.ir', 'سلام\r\nاین نظر رو میذارم که بدونی به یادتم\r\n:-)', 0, '1391-05-12 13:40:35');

-- --------------------------------------------------------

--
-- Table structure for table `gl_contact_details`
--

DROP TABLE IF EXISTS `gl_contact_details`;
CREATE TABLE IF NOT EXISTS `gl_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'title of contact',
  `manager` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'manager name of company or web site',
  `telephone_1` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company tel #1 example : 05118456628',
  `telephone_2` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company tel #2 example : 05118456629',
  `fax` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company fax number',
  `mobile` varchar(11) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'manger mobile number or company mobile number',
  `sms_center` varchar(14) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'company sms center for example : 3000662849',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gl_contact_details`
--

INSERT INTO `gl_contact_details` (`id`, `title`, `manager`, `telephone_1`, `telephone_2`, `fax`, `mobile`, `sms_center`) VALUES
(1, 'اطلاعات تماس شرکت اندیشه نوین', 'علیرضا جهانگیری', '05118456628', '05118456629', '05118404006', '09155000106', '3000253574123'),
(2, 'اطلاعات تماس بانیان', 'احسان شهابی کارگر', '', '', '', '09159966451', '');

-- --------------------------------------------------------

--
-- Table structure for table `gl_content_categories`
--

DROP TABLE IF EXISTS `gl_content_categories`;
CREATE TABLE IF NOT EXISTS `gl_content_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0' COMMENT 'parent id of a category default is 0 this mean the category is parent! ',
  `name` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'name of category',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gl_content_categories`
--

INSERT INTO `gl_content_categories` (`id`, `parent_id`, `name`, `published`, `lft`, `rght`) VALUES
(2, 0, 'اخبار', 1, 1, 4),
(3, 2, 'اخبار فناوری اطلاعات', 1, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `gl_contents`
--

DROP TABLE IF EXISTS `gl_contents`;
CREATE TABLE IF NOT EXISTS `gl_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'the id of user from users table who post the content',
  `content_category_id` int(11) NOT NULL COMMENT 'id of content category',
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `content` text COLLATE utf8_persian_ci NOT NULL,
  `allow_comment` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'determine users can adding comments to this post or not?',
  `published_comment` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'this field determine comment show after added by users or after published by administrator',
  `frontpage` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'status of content to show on the frontpage or not in the other pages By default all content is in other pages!',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'status of content to be published or not By default all content is published',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_gl_contents_slug` (`slug`),
  KEY `content_category_id` (`content_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gl_contents`
--

INSERT INTO `gl_contents` (`id`, `user_id`, `content_category_id`, `title`, `slug`, `content`, `allow_comment`, `published_comment`, `frontpage`, `published`, `created`, `modified`) VALUES
(1, 1, 3, 'با دستخط خود در گوگل جستجو کنید', 'با_دستخط_خود_در_گوگل_جستجو_کنید', '<p>برخلاف جستجو کردن با استفاده از کیبورد لپتاپ و یا دسکتاپ که کار بسیار  سریع و تقریبا بدون اشتباهی است، جستجو با استفاده کیبورد مجازی دستگاه های  موبایل معمولا سخت و پر اشتباه است. به همین دلیل گوگل برای تسهیل این کار  خدمات مختلفی مانند جستجو با استفاده از صوت، جستجوی تصویری، و کامل شدن نتایج جستجو در زمان تایپ کردن را مدت هاست که به امکانات خود اضافه کرده است. اما امروز گوگل در وبلاگ رسمی اش، خبر از اضافه کردن امکان دیگری با نام "جستجو با استفاده از دست خط" داد.</p>', 1, 0, 1, 1, '1391-05-12 09:46:35', '2012-08-17 21:41:35'),
(2, 1, 2, 'می خوام یه تصمیم سخت بگیرم', 'می_خوام_یه_تصمیم_سخت_بگیرم', '<p>سلام</p>\r\n<p>امروز می خوام یه تصمیم سخت بگیرم</p>\r\n<p>می ترسم آقای جهانگیری ناراحت بشه ولی خوب شما می گید من چیکار کنم</p>\r\n<p>باید از این بلاتکلیفی خودمو نجات بدم</p>\r\n<p>دیگه خسته شدم :(</p>', 1, 0, 1, 1, '1391-05-17 13:51:02', '2012-08-20 22:38:55');

-- --------------------------------------------------------

--
-- Table structure for table `gl_gallery_categories`
--

DROP TABLE IF EXISTS `gl_gallery_categories`;
CREATE TABLE IF NOT EXISTS `gl_gallery_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'category parent id  By default all category added to the app is parent while the admin did ''nt  select a parent for its',
  `name` varchar(30) COLLATE utf8_persian_ci NOT NULL,
  `folder_name` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'category folder name for inserting images! for example image category folder is stored to : app/webroot/images/gallery \r\n and category name is MyFreinds so the images which added to this category will stored into :  app/webroot/images/gallery/MyFreinds',
  `published` int(11) DEFAULT NULL,
  `lft` tinyint(4) NOT NULL,
  `rght` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gl_gallery_categories`
--

INSERT INTO `gl_gallery_categories` (`id`, `parent_id`, `name`, `folder_name`, `published`, `lft`, `rght`) VALUES
(1, 0, 'طنز', 'fun', 1, 1, 2),
(2, 0, 'سیاسی', 'poletic', 0, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `gl_gallery_items`
--

DROP TABLE IF EXISTS `gl_gallery_items`;
CREATE TABLE IF NOT EXISTS `gl_gallery_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'user id who added this image!',
  `gallery_category_id` int(11) NOT NULL,
  `title` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'image title',
  `image_file_name` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'image name for accessing to it on gallery category folder',
  `description` text COLLATE utf8_persian_ci COMMENT 'image descriptions',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all images is published!',
  PRIMARY KEY (`id`),
  KEY `gallery_category_id` (`gallery_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `gl_gallery_items`
--

INSERT INTO `gl_gallery_items` (`id`, `user_id`, `gallery_category_id`, `title`, `image_file_name`, `description`, `published`) VALUES
(1, 1, 1, 'طنز شیمی', '251873_303336733095315_1539053429_n.jpg', '', 1),
(2, 1, 2, 'test', '165846_311282258966437_307164411_n.jpg', '', 1),
(3, 1, 1, 'برنامه نویسی', '282986_2886777306886_1617055417_n.jpg', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gl_menu_types`
--

DROP TABLE IF EXISTS `gl_menu_types`;
CREATE TABLE IF NOT EXISTS `gl_menu_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `gl_menu_types`
--

INSERT INTO `gl_menu_types` (`id`, `type`, `title`, `description`) VALUES
(1, 'mainmenu', 'منوی اصلی', ''),
(5, 'leftmenu', 'منوی چپ', ''),
(6, '321', '213', '');

-- --------------------------------------------------------

--
-- Table structure for table `gl_menus`
--

DROP TABLE IF EXISTS `gl_menus`;
CREATE TABLE IF NOT EXISTS `gl_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'menu parent id for example a gallery menu which link''s to My Friends Gallery is a Child of Gallery menu which was an separator menu type   By default all menu is parent=>0',
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'menu alias for using on slugs',
  `link_type` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `menu_type_id` int(11) NOT NULL COMMENT 'menu type for example :  1) contact 2) gallery 3) static page(linked to content) 4) web links 5) register 6) menu separator 7) site map ,.....',
  `published` int(1) NOT NULL DEFAULT '1' COMMENT 'By default all menu is published',
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `gl_menus`
--

INSERT INTO `gl_menus` (`id`, `parent_id`, `title`, `link`, `link_type`, `menu_type_id`, `published`, `lft`, `rght`, `level`) VALUES
(3, 0, 'صفحه اصلی', 'http://localhost/gilas/Contents/view/2', 'Contents', 1, 1, 1, 2, 0),
(4, 0, '21', 'http://localhost/gilas/Contents/view/1', 'Contents', 1, 1, 3, 4, 0),
(5, 0, 'ارتباط با ما', 'http://localhost/gilas-old/ContactDetails/view/1', 'ContactDetails', 6, 1, 11, 12, 0),
(7, 0, 'ارتباط با ما', 'http://localhost/gilas/Contents/view/2', 'Contents', 1, 1, 5, 6, 0),
(8, 0, 'مطالب', 'http://localhost/gilas/Contents/view/1', 'Contents', 1, 1, 7, 8, 0),
(9, 0, 'asdf', 'http://localhost/gilas/Contents/view/2', 'Contents', 1, 1, 9, 10, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gl_settings`
--

DROP TABLE IF EXISTS `gl_settings`;
CREATE TABLE IF NOT EXISTS `gl_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `key` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `gl_settings`
--

INSERT INTO `gl_settings` (`id`, `section`, `key`, `value`, `alias`, `modified`) VALUES
(1, 'Site', 'Name', 'اندیشه نوین بارثاوا', 'عنوان سایت', NULL),
(2, 'Site', 'Keywords', 'گیلاس,سیستم مدیریت محتوای فارسی,کیک پی اچ پی,CMS,CakePHP,Gilas', 'توضیحات', NULL),
(3, 'Site', 'Description', 'سیستم مدیریت محتوای گیلاس تولید شده در دپارتمان وب شرکت اندیشه نوین', 'توضیحات', NULL),
(4, 'Site', 'FootNote', 'کلیه حقوق مادی و معنوی این نرم افزار متعلق به شرکت اندیشه نوین می باشد.', 'پانویس', NULL),
(5, 'Site', 'AdminAddress', 'gilas', 'آدرس مدیریت', NULL),
(6, 'Error', 'Code-11', 'خطای شماره 11 - امکان ورود به سیستم وجود ندارد!', 'خطای شماره 11', NULL),
(7, 'Error', 'Code-12', 'خطای شماره 12 - درخواست شما نا معتبر است و امکان بررسی آن وجود ندارد!', 'خطای شماره 12', NULL),
(8, 'Error', 'Code-13', 'خطای شماره 13 - اطلاعات وارد شده معتبر نمی باشد. لطفا به خطاهای سیستم دقت کرده و مجددا تلاش نمایید!', 'خطای شماره 13', NULL),
(9, 'Error', 'Code-14', 'خطای شماره 14 – امکان انجام عملیات درخواستی بدلیل ارسال نادرست اطلاعات وجود ندارد!', 'خطای شماره 14', NULL),
(10, 'Error', 'Code-15', 'خطای شماره 15 – امکان حذف به علت دارا بودن آیتم های زیر مجموعه وجود ندارد. لطفا ابتدا آیتم های زیر مجموعه را حذف نمایید!', 'خطای شماره 15', NULL),
(11, 'Error', 'Code-16', 'خطای شماره 16 - به هر دلیلی امکان حذف وجود ندارد!', 'خطای شماره 16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gl_slider_items`
--

DROP TABLE IF EXISTS `gl_slider_items`;
CREATE TABLE IF NOT EXISTS `gl_slider_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'reference link for this slide',
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'image title',
  `description` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'image description for displaying under title!',
  `image_file_name` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'image name for accessing the true image on the slider folder! for example :  app/webroot/images/slider/slide_01.jpg',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all images in slider is published!',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gl_users`
--

DROP TABLE IF EXISTS `gl_users`;
CREATE TABLE IF NOT EXISTS `gl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_persian_ci NOT NULL COMMENT 'username must be unique',
  `password` varchar(40) COLLATE utf8_persian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'Both Of first name and last name',
  `email` varchar(50) COLLATE utf8_persian_ci DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'activation status of users By default all users is deactivated',
  `registered_date` datetime NOT NULL,
  `last_logged_in` datetime NOT NULL COMMENT 'latest login of user to the web site',
  `last_ip_logged_in` varchar(15) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_gl_users_username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_users`
--

INSERT INTO `gl_users` (`id`, `username`, `password`, `name`, `email`, `active`, `registered_date`, `last_logged_in`, `last_ip_logged_in`) VALUES
(1, 'admin', '9ee2c9367485427679bd7a0ec1c7f3263869b387', 'محمد رزاقی', '1razzaghi@gmail.com', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `gl_weblink_categories`
--

DROP TABLE IF EXISTS `gl_weblink_categories`;
CREATE TABLE IF NOT EXISTS `gl_weblink_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_weblink_categories`
--

INSERT INTO `gl_weblink_categories` (`id`, `name`) VALUES
(1, 'فناوری اطلاعات و ارتباطات');

-- --------------------------------------------------------

--
-- Table structure for table `gl_weblinks`
--

DROP TABLE IF EXISTS `gl_weblinks`;
CREATE TABLE IF NOT EXISTS `gl_weblinks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblink_category_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_persian_ci NOT NULL COMMENT 'links title',
  `description` varchar(100) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'links description',
  `address` varchar(100) COLLATE utf8_persian_ci NOT NULL COMMENT 'link address',
  `hits` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'number of link hits after each click on link hits +1',
  `published` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'By default all link is published',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weblink_category_id` (`weblink_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `gl_weblinks`
--

INSERT INTO `gl_weblinks` (`id`, `weblink_category_id`, `title`, `description`, `address`, `hits`, `published`, `created`) VALUES
(1, 1, 'اندیشه نوین بارثاوا', 'فعال در زمینه فناوری اطلاعات', 'http://novin-it.com', 0, 1, '1391-05-24 13:36:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
