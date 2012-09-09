-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_category`
-- 

CREATE TABLE `tl_visitors_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(60) NOT NULL default '', 
  `visitors_template` varchar(32) NOT NULL default '', 
  `visitors_cache_mode` tinyint(3) unsigned NOT NULL default '1', 
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors`
-- 

CREATE TABLE `tl_visitors` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `visitors_startdate` varchar(10) NOT NULL default '',
  `visitors_name` varchar(64) NOT NULL default '',
  `visitors_average` char(1) NOT NULL default '',
  `visitors_visit_start` int(10) unsigned NOT NULL default '0', 
  `visitors_hit_start` int(10) unsigned NOT NULL default '0', 
  `visitors_block_time` int(10) unsigned NOT NULL default '1800', 
  `visitors_thousands_separator` char(1) NOT NULL default '',
  `published` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_counter`
-- 

CREATE TABLE `tl_visitors_counter` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `vid` int(10) unsigned NOT NULL default '0',
  `visitors_date` date NOT NULL default '1999-01-01',
  `visitors_visit` int(10) unsigned NOT NULL default '0', 
  `visitors_hit` int(10) unsigned NOT NULL default '0', 
  PRIMARY KEY  (`id`),
  UNIQUE KEY `vid_date` (`vid`, `visitors_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_blocker`
-- 

CREATE TABLE `tl_visitors_blocker` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `vid` int(10) unsigned NOT NULL default '0',
  `visitors_tstamp` timestamp NULL default NULL,
  `visitors_ip` varchar(40) NOT NULL default '0.0.0.0',
  `visitors_type` char(1) NOT NULL default 'v',
  PRIMARY KEY  (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_browser`
-- 

CREATE TABLE `tl_visitors_browser` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `vid` int(10) unsigned NOT NULL default '0',
  `visitors_browser` varchar(60) NOT NULL default 'Unknown',
  `visitors_os` varchar(60) NOT NULL default 'Unknown',
  `visitors_lang` varchar(10) NOT NULL default 'Unknown',
  `visitors_counter` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_searchengines`
-- 

CREATE TABLE `tl_visitors_searchengines` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `vid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `visitors_searchengine` varchar(60) NOT NULL default 'Unknown',
  `visitors_keywords` varchar(255) NOT NULL default 'Unknown',
  PRIMARY KEY  (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_visitors_referrer`
-- 

CREATE TABLE `tl_visitors_referrer` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `vid` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `visitors_referrer_dns` varchar(255) NOT NULL default '-',
  `visitors_referrer_full` text NULL,
  PRIMARY KEY  (`id`),
  KEY `vid` (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `visitors_categories` varchar(255) NOT NULL default '',
  `visitors_useragent` varchar(64) NOT NULL default '',
  `visitors_template` varchar(32) NOT NULL default '', 
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
