<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Config File
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

define('VISITORS_VERSION', '3.1');
define('VISITORS_BUILD'  , '1');

/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 */
$GLOBALS['BE_MOD']['content']['visitors'] = array
(
	'tables'     => array('tl_visitors_category', 'tl_visitors'),
	'icon'       => 'system/modules/visitors/assets/iconVisitor.png',
	'stylesheet' => 'system/modules/visitors/assets/mod_visitors_be.css'
);

$GLOBALS['BE_MOD']['system']['visitorstat'] = array
(
	'callback'   => 'Visitors\ModuleVisitorStat',
	'icon'       => 'system/modules/visitors/assets/iconVisitor.png',
	'stylesheet' => 'system/modules/visitors/assets/mod_visitors_be.css'
);

/**
 * -------------------------------------------------------------------------
 * FRONT END MODULES
 * -------------------------------------------------------------------------
 */
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
(
	'visitors' => 'Visitors\ModuleVisitors',
));

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('Visitors\ModuleVisitorsTag', 'ReplaceInsertTagsVisitors');
