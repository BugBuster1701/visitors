<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Visitors - Backend DCA tl_visitors
 *
 * This is the data container array for table tl_visitors.
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012 
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

/**
 * Table tl_visitors 
 */
$GLOBALS['TL_DCA']['tl_visitors'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_visitors_category',
		'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id'  => 'primary',
                'pid' => 'index'
            )
        )
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'filter'                  => true,
			'fields'                  => array('sorting'),
			'panelLayout'             => 'search,filter,limit',
			'headerFields'            => array('title', 'tstamp'), //, 'visitors_template'
			'child_record_callback'   => array('BugBuster\Visitors\DCA_visitors', 'listVisitors')
		),/**
		'label' => array
		(
			'fields'                  => array(''),
			'format'                  => '%s'
		),**/
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'toggle' => array
            (
                    'label'               => &$GLOBALS['TL_LANG']['tl_visitors']['toggle'],
                    'icon'                => 'visible.gif',
                    'attributes'          => 'onclick="Backend.getScrollOffset(); return AjaxRequest.toggleVisibility(this, %s);"',
                    'button_callback'     => array('BugBuster\Visitors\DCA_visitors', 'toggleIcon')
            ),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		//'__selector__'                => array(''),
		'default'                     => '{title_legend},visitors_name,visitors_startdate;{start_legend:hide},visitors_visit_start,visitors_hit_start;{average_legend},visitors_average,visitors_block_time;{design_legend},visitors_thousands_separator;{publish_legend},published'
	),

	// Subpalettes
	/**'subpalettes' => array
	(
		''                            => ''
	),**/

	// Fields
	'fields' => array
	(
    	'id' => array
    	(
    	        'sql'       => "int(10) unsigned NOT NULL auto_increment"
    	),
    	'pid' => array
    	(
    	        'sql'       => "int(10) unsigned NOT NULL default '0'"
    	),
    	'sorting' => array
    	(
    	        'sql'       => "int(10) unsigned NOT NULL default '0'"
    	),
    	'tstamp' => array
    	(
    	        'sql'       => "int(10) unsigned NOT NULL default '0'"
    	),
	    'visitors_name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_name'],
			'inputType'               => 'text',
			'search'                  => true,
			'explanation'	          => 'visitors_help',
			'sql'                     => "varchar(64) NOT NULL default ''",
			'eval'                    => array('mandatory'=>true, 'maxlength'=>40, 'helpwizard'=>true, 'tl_class'=>'w50')
		),
		'visitors_startdate' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate'],
			'inputType'               => 'text',
			'explanation'	          => 'visitors_help',
			'sql'                     => "varchar(10) NOT NULL default ''",
			'eval'                    => array('maxlength'=>10, 'rgxp'=>'date', 'helpwizard'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'visitors_visit_start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_visit_start'],
			'inputType'               => 'text',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_hit_start'   => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_hit_start'],
			'inputType'               => 'text',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_average'   => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_average'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'sql'                     => "char(1) NOT NULL default ''",
			'eval'					  => array('tl_class'=>'w50')
		),
		'visitors_block_time'	=> array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_block_time'],
			'inputType'               => 'text',
			'sql'                     => "int(10) unsigned NOT NULL default '1800'",
			'eval'                    => array('mandatory'=>true, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_thousands_separator'=> array
		(
			'label'					  => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_thousands_separator'],
			'inputType'               => 'checkbox',
			'sql'                     => "char(1) NOT NULL default ''",
			'eval'                    => array('mandatory'=>false, 'helpwizard'=>false)
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'sql'                     => "char(1) NOT NULL default ''",
			'eval'                    => array('doNotCopy'=>true)
		)
	)
);

