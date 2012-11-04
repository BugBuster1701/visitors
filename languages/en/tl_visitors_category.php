<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors_category (en).
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012 
 * @author     Glen Langer 
 * @package    VisitorsLanguage 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['title']              = array('Title', 'Please enter the title of the category.');
$GLOBALS['TL_LANG']['tl_visitors_category']['tstamp']             = array('Revision date', 'Date and time of latest revision');
$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_cache_mode']= array('Counting mode', 'Counting method when pages are cached.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['title_legend']     = 'Title and counter template'; 
$GLOBALS['TL_LANG']['tl_visitors_category']['cache_legend']     = 'Counting mode'; 

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['deleteConfirm'] = 'Deleting a category will also delete all its counter informations. Do you really want to delete category ID %s?';
$GLOBALS['TL_LANG']['tl_visitors_category']['1'] = 'Load counting, server side by Contao';
$GLOBALS['TL_LANG']['tl_visitors_category']['2'] = 'Read counting, client side by browser (only on Contao cacheMode: server and browser cache / only browser cache)';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['new']    = array('New category', 'Create a new category');
$GLOBALS['TL_LANG']['tl_visitors_category']['edit']   = array('Edit category', 'Edit category ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['copy']   = array('Copy category', 'Copy category ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['delete'] = array('Delete category', 'Delete category ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['show']   = array('Category details', 'Show details of category ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['stat']   = array('Category statistic', 'Show counter statistic for category ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['editheader'] = array('Edit category settings', 'Edit the settings of category ID %s');
