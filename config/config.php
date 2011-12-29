<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Config File
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2011
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */


/**
 * -------------------------------------------------------------------------
 * BACK END MODULES
 * -------------------------------------------------------------------------
 *
 * Back end modules are stored in a global array called "BE_MOD". Each module 
 * has certain properties like an icon, an optional callback function and one 
 * or more tables. Each module belongs to a particular group.
 * 
 *   $GLOBALS['BE_MOD'] = array
 *   (
 *       'group_1' => array
 *       (
 *           'module_1' => array
 *           (
 *               'tables'       => array('table_1', 'table_2'),
 *               'key'          => array('Class', 'method'),
 *               'callback'     => 'ClassName',
 *               'icon'         => 'path/to/icon.gif',
 *               'stylesheet'   => 'path/to/stylesheet.css',
 *               'javascript'   => 'path/to/javascript.js'
 *           )
 *       )
 *   );
 * 
 * Use function array_insert() to modify an existing modules array.
 */
$GLOBALS['BE_MOD']['content']['visitors'] = array
(
	'tables'     => array('tl_visitors_category', 'tl_visitors'),
	//'icon'       => ModuleVisitorFile::VisitorIcon('iconVisitor.png'),
	'icon'       => 'system/modules/visitors/iconVisitor.png',
	//'stylesheet' => ModuleVisitorFile::VisitorCss('mod_visitors_be.css')
	'stylesheet' => 'system/modules/visitors/mod_visitors_be.css'
);

array_insert($GLOBALS['BE_MOD']['system'], 1, array
(
	'visitorstat' => array
	(
		'callback'   => 'ModuleVisitorStat',
		//'icon'       => ModuleVisitorFile::VisitorIcon('iconVisitor.png'),
		'icon'       => 'system/modules/visitors/iconVisitor.png',
		//'stylesheet' => ModuleVisitorFile::VisitorCss('mod_visitors_be.css')
		'stylesheet' => 'system/modules/visitors/mod_visitors_be.css'
	)
));

/**
 * -------------------------------------------------------------------------
 * FRONT END MODULES
 * -------------------------------------------------------------------------
 *
 * List all fontend modules and their class names.
 * 
 *   $GLOBALS['FE_MOD'] = array
 *   (
 *       'group_1' => array
 *       (
 *           'module_1' => 'Contentlass',
 *           'module_2' => 'Contentlass'
 *       )
 *   );
 * 
 * Use function array_insert() to modify an existing CTE array.
 */
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
(
	'visitors' => 'ModuleVisitors',
));

/**
 * -------------------------------------------------------------------------
 * HOOKS
 * -------------------------------------------------------------------------
 *
 * Hooking allows you to register one or more callback functions that are 
 * called on a particular event in a specific order. Thus, third party 
 * extensions can add functionality to the core system without having to
 * modify the source code.
 * 
 *   $GLOBALS['TL_HOOKS'] = array
 *   (
 *       'hook_1' => array
 *       (
 *           array('Class', 'Method'),
 *           array('Class', 'Method')
 *       )
 *   );
 * 
 * Use function array_insert() to modify an existing hooks array.
 */
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('ModuleVisitorsTag', 'ViReplaceInsertTags');

if (version_compare(VERSION . '.' . BUILD, '2.9.9', '<'))
{
	/**
	 * Migration over module based runonce
	 * 
	 * Check for exists of /system/runonce
	 * if not, copy the module runonce therefore
	 */
	$runonceJob  = 'system/modules/visitors/config/RunonceJob.php';
	$runonceFile = 'system/runonce.php';
	
	if ( (file_exists(TL_ROOT . '/' . $runonceJob)) && (!file_exists(TL_ROOT . '/' . $runonceFile)) ) 
	{
		//keine /system/runonce, let's go
		$objFile = new File($runonceJob); // hier wird intern ein "TL_ROOT/" vorgesetzt
	
		if ($objFile->filesize > 100) 
		{
			$objFiles = Files::getInstance();
			$objFiles->copy($runonceJob,$runonceFile);
			//
			if (version_compare(VERSION . '.' . BUILD, '2.8.9', '>'))
			{
				$objFile->write("<?php // Module Migration Complete ?>");
			}
		}
		$objFile->close();
	}
}
?>