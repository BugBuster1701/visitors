<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors (en).
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2010 
 * @author     Glen Langer 
 * @package    VisitorsLanguage 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_visitors']['visitors_name']      = array('Name', 'Please enter a name for this counter.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate'] = array('Start date', 'Here you can define a start date. In the front end this date will be displayed.<br>It does not affect the start of counting!');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_visit_start'] = array('Initial value of visitors', 'The entered number is added to the counter.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_hit_start'] = array('Initial value of hits', 'The entered number is added to the counter.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_average']   = array('Visitors per day', 'With activation is also displayed in the front end a line with the average number of visitors per day.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_block_time']   = array('Block time', 'After interruption of the requests at this time, an access is counted as an additional visitor.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_thousands_separator'] = array('Thousands separator','With activation, the thousands separator are also displayed in the front end.');
$GLOBALS['TL_LANG']['tl_visitors']['published']          = array('Published', 'The counter will not be visible on your website until it is published.');

/**
 * Reference
 */
//$GLOBALS['TL_LANG']['tl_visitors'][''] = '';
$GLOBALS['TL_LANG']['tl_visitors']['not_defined']   = 'Not defined';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors']['title_legend']   = 'Name and start date';
$GLOBALS['TL_LANG']['tl_visitors']['start_legend']   = 'Optional initial values';
$GLOBALS['TL_LANG']['tl_visitors']['average_legend'] = 'Average and blocktime';
$GLOBALS['TL_LANG']['tl_visitors']['publish_legend'] = 'Publish settings';
$GLOBALS['TL_LANG']['tl_visitors']['design_legend']  = 'Design';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors']['new']        = array('New counter', 'Create a new counter');
$GLOBALS['TL_LANG']['tl_visitors']['edit']       = array('Edit counter', 'Edit counter ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['copy']       = array('Duplicate counter', 'Duplicate counter ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['delete']     = array('Delete counter', 'Delete counter ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['show']       = array('Details', 'Show details of counter ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['editheader'] = array('Edit category', 'Edit this category');
$GLOBALS['TL_LANG']['tl_visitors']['toggle']     = array('Toggle visibility', 'Toggle the visibility of counter ID %s');

/**
 * Errorlog
 */
$GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'] = 'Faulty or incorrect category ID (parameter 2)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_key']   = 'Faulty or incorrect tag name (parameter 3)';
$GLOBALS['TL_LANG']['tl_visitors']['no_key']      = 'Tag name was not specified (parameter 3)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_count_katid'] = 'Call without parameter';
$GLOBALS['TL_LANG']['tl_visitors']['no_param4']   = 'Call without parameter 4';

?>