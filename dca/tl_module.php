<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors - Backend DCA tl_module
 *
 * This file modifies the data container array of table tl_module.
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer
 * @package    GLVisitors
 * @license    LGPL
 * @filesource
 */


/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['visitors']   = 'name,type,headline;visitors_categories,visitors_template;guests,protected,visitors_useragent;align,space,cssID';



/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['visitors_categories'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['visitors_categories'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'foreignKey'              => 'tl_visitors_category.title',
	'eval'                    => array('multiple'=>false, 'mandatory'=>true, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['visitors_template'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['visitors_template'],
    'default'                 => 'mod_visitors_fe_all',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('BugBuster\Visitors\DCA_module_visitors', 'getVisitorsTemplates'), 
    'eval'                    => array('tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_module']['fields']['visitors_useragent'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['visitors_useragent'],
	'inputType'               => 'text',
	'search'                  => true,
	'explanation'	          => 'visitors_help_module',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>64, 'helpwizard'=>true)
);
