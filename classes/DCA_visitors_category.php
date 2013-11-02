<?php 

/**
 * Contao Open Source CMS, Copyright (C) 2005-2013 Leo Feyer
 *
 * Contao Module "Visitors" - DCA Helper Class DCA_visitors_category
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/visitors
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Visitors;

/**
 * DCA Helper Class DCA_visitors_category
 *
 * @copyright  Glen Langer 2012..2013 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 *
 */
class DCA_visitors_category extends \Backend 
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