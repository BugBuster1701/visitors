<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Visitors Banner - Backend DCA tl_visitors_category
 *
 * This is the data container array for table tl_visitors_category.
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

class tl_visitors_category extends Backend
{
	public function labelCallback($arrRow)
	{
		$label_1 = $arrRow['title'];
		$label_2 = ' <span style="color: #B3B3B3;">[ID:'.$arrRow['id'].']</span>';
		if (version_compare(VERSION , '2.99', '>'))
		{
			$version_warning = '';
		} else {
			$version_warning = '<br /><span style="color:#ff0000;">[ERROR: Visitors-Module requires at least Contao 3.0]</span>';
		}
		return $label_1 . $label_2 . $version_warning;//. '<br /><span style="color:#b3b3b3;">['.$label_2.']</span>';
	}
}

/**
 * Table tl_visitors_category 
 */
$GLOBALS['TL_DCA']['tl_visitors_category'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_visitors'),
		'switchToEdit'                => true,
		'enableVersioning'            => true
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title'),
			'flag'                    => 1,
			'panelLayout'             => 'search,limit'
		),
		'label' => array
		(
			'fields'                  => array('tag'),
			'format'                  => '%s',
			'label_callback'		  => array('tl_visitors_category', 'labelCallback'),
		),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['edit'],
				'href'                => 'table=tl_visitors',
				'icon'                => 'edit.gif',
				'attributes'          => 'class="contextmenu"'
			),
			'editheader' => array
			(
		        'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['editheader'],
		        'href'                => 'act=edit',
		        'icon'                => 'header.gif',
		        'attributes'          => 'class="edit-header"'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_visitors_category']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			),
			'stat' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_visitors_category']['stat'],
				'href'                => 'do=visitorstat',
				'icon'                => 'system/modules/visitors/assets/iconVisitor.png'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		//'__selector__'                => array(''),
		'default'                     => '{title_legend},title;{cache_legend:hide},visitors_cache_mode'
	),

	// Subpalettes
	/**'subpalettes' => array
	(
		''                            => ''
	),**/

	// Fields
	'fields' => array
	(
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors_category']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>60, 'tl_class'=>'w50')
		),
		'visitors_cache_mode' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_cache_mode'],
			'exclude'                 => true,
			'default'                 => '1',
			'inputType'               => 'radio',
			'options'                 => array('1', '2'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_visitors_category'],
			'eval'                    => array('mandatory'=>true)
		)
	)
);

