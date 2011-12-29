<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Visitors - Backend DCA tl_visitors
 *
 * This is the data container array for table tl_visitors.
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2011 
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

/**
 * Class tl_visitors
 *
 * Methods that are used by the DCA
 */
class tl_visitors extends Backend
{
	/**
     * Import the back end user object
     */
    public function __construct()
    {
            parent::__construct();
            $this->import('BackendUser', 'User');
    }
	
	public function listVisitors($arrRow)
	{
	    $key = $arrRow['published'] ? 'published' : 'unpublished';
	    if (!strlen($arrRow['visitors_startdate'])) {
	    	$startdate = $GLOBALS['TL_LANG']['tl_visitors']['not_defined'];
	    } else {
	    	$startdate = date($GLOBALS['TL_CONFIG']['dateFormat'], $arrRow['visitors_startdate']);
	    }
	    $output = '<div class="cte_type ' . $key . '"><strong>' . $arrRow['visitors_name'] . '</strong></div>' ;
	    $output.= '<div>'.$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate'][0].': ' . $startdate . '</div>';
	    //$output.= '<div>'.print_r($arrRow,true).'</div>';
	    return $output;
	}
	
	/**
     * Return the "toggle visibility" button
     * @param array
     * @param string
     * @param string
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
            if (strlen($this->Input->get('tid')))
            {
                    $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 1));
                    $this->redirect($this->getReferer());
            }

            // Check permissions AFTER checking the tid, so hacking attempts are logged
            if (!$this->User->isAdmin && !$this->User->hasAccess('tl_visitors::published', 'alexf'))
            {
            	return '';
            }

            $href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

            if (!$row['published'])
            {
                    $icon = 'invisible.gif';
            }

            return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.$this->generateImage($icon, $label).'</a> ';
    }
    
    /**
     * Disable/enable a counter
     * @param integer
     * @param boolean
     */
    public function toggleVisibility($intId, $blnVisible)
    {
            // Check permissions to publish
            if (!$this->User->isAdmin && !$this->User->hasAccess('tl_visitors::published', 'alexf'))
            {
                    $this->log('Not enough permissions to publish/unpublish Visitors ID "'.$intId.'"', 'tl_visitors toggleVisibility', TL_ERROR);
                    $this->redirect('contao/main.php?act=error');
            }

            // Update database
            $this->Database->prepare("UPDATE tl_visitors SET published='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
                           ->execute($intId);
    }
}

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
		'enableVersioning'            => true
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
			'child_record_callback'   => array('tl_visitors', 'listVisitors')
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
                    'button_callback'     => array('tl_visitors', 'toggleIcon')
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
	    'visitors_name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_name'],
			'inputType'               => 'text',
			'search'                  => true,
			'explanation'	          => 'visitors_help',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>40, 'helpwizard'=>true, 'tl_class'=>'w50')
		),
		'visitors_startdate' => array
		(
			'exclude'                 => true,
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate'],
			'inputType'               => 'text',
			'explanation'	          => 'visitors_help',
			'eval'                    => array('maxlength'=>10, 'rgxp'=>'date', 'helpwizard'=>true, 'datepicker'=>$this->getDatePickerString(), 'tl_class'=>'w50 wizard')
		),
		'visitors_visit_start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_visit_start'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_hit_start'   => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_hit_start'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>false, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_average'   => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_average'],
			'exclude'                 => true,
			'inputType'               => 'checkbox',
			'eval'					  => array('tl_class'=>'w50')
		),
		'visitors_block_time'	=> array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_block_time'],
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>10, 'rgxp'=>'digit', 'helpwizard'=>false, 'tl_class'=>'w50')
		),
		'visitors_thousands_separator'=> array
		(
			'label'					  => &$GLOBALS['TL_LANG']['tl_visitors']['visitors_thousands_separator'],
			'inputType'               => 'checkbox',
			'eval'                    => array('mandatory'=>false, 'helpwizard'=>false)
		),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_visitors']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 2,
			'inputType'               => 'checkbox',
			'eval'                    => array('doNotCopy'=>true)
		)
	)
);

?>