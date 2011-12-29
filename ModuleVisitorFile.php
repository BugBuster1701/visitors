<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors File - Backend
 * 
 * PHP version 5
 * @copyright  Glen Langer 2009..2010
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 * @filesource
 */


/**
 * Class ModuleVisitorFile
 *
 * @copyright  Glen Langer 2009..2010
 * @author     Glen Langer
 * @package    GLVisitors
 * @license    LGPL 
 */
class ModuleVisitorFile
{
    /**
     * Get DIRECTORY_SEPARATOR
     *
     * @var string
     */
    public static $dirsep    = DIRECTORY_SEPARATOR;
    
    /**
     * Set Windows Directory Separator '\', masked
     *
     * @var string
     */
    public static $dirsepwin = '\\';
    
	/**
	 * Get Path/file of the icon file
	 *
	 * @param string $file
	 * @return string
	 */
	public static function VisitorIcon($file)
	{
   	    $ModuleBannerDirPath = realpath(dirname(__FILE__));
	    $ModuleBannerRelPath = substr($ModuleBannerDirPath, strlen(TL_ROOT)+1);
	    if (self::$dirsep == self::$dirsepwin) { //Windows is here...
            $ModuleBannerRelPath = str_replace(self::$dirsepwin, '/', $ModuleBannerRelPath);
        }
	    return $ModuleBannerRelPath.'/'.$file;
	}
	
	/**
	 * Get Path/file of the css file
	 *
	 * @param string $file
	 * @return string
	 */
	public static function VisitorCss($file)
	{
   	    $ModuleBannerDirPath = realpath(dirname(__FILE__));
	    $ModuleBannerRelPath = substr($ModuleBannerDirPath, strlen(TL_ROOT)+1);
	    if (self::$dirsep == self::$dirsepwin) { //Windows is here...
            $ModuleBannerRelPath = str_replace(self::$dirsepwin, '/', $ModuleBannerRelPath);
        }
	    return $ModuleBannerRelPath.'/'.$file;
	}
}

?>