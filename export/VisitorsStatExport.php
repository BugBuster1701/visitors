<?php 

/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Visitors Statistik Export
 *
 * wird per export button direkt über Formular aufgerufen als popup
 * 
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @licence    LGPL
 * @filesource
 * @package    GLVisitors
 * @see	       https://github.com/BugBuster1701/visitors
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Visitors;

/**
 * Initialize the system
 */
define('TL_MODE', 'BE');
require('../../../initialize.php');

/**
 * Class VisitorsStatExport
 *
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 */
class VisitorsStatExport extends \Backend // Backend bringt DB mit
{
    /**
	 * Export Type
	 */
	protected $strExportType ='';
	
	/**
	 * Export Delimiter
	 */
    protected $strExportDelimiter ='';
    
    /**
	 * Set the current file
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct(); 
		$this->User->authenticate(); 
	    $this->loadLanguageFile('default');
		$this->loadLanguageFile('modules');
		$this->loadLanguageFile('tl_visitors'); 
	}
	
    // Die parametrisierte Factorymethode
    public function factory($type)
    {
    	/*
        if (@include(realpath(dirname(__FILE__)) . '/VisitorsStatExport' . $type . '.php')) {
            $classname = 'VisitorsStatExport' . $type;
            return new $classname;
        } else {
            return false;
        }
        */
        $classname = 'VisitorsStatExport' . $type;
        $this->import('Visitors\\' . $classname ,$classname); 
        return $this->$classname;
    }

    public function run()
	{
   	    if ( (!\Input::get('tl_field',true)=='csvc') && 
   	         (!\Input::get('tl_field',true)=='csvs') && 
   	         (!\Input::get('tl_field',true)=='excel') 
   	       ) 
   	    {
   	        echo "<html><body>Missing Parameter!</body></html>";
            return ;
	    }
	    if ((int)\Input::get('tl_katid',true)<1) 
	    {
	    	echo "<html><body>Wrong Parameter!</body></html>";
            return ;
	    }
	    $intVisitorKatId = (int)\Input::get('tl_katid',true);
	    switch (\Input::get('tl_field',true)) 
	    {
	    	case "csvc":
                $this->strExportType = 'csv';
	    	    $this->strExportDelimiter = ',';
	    		break;
	    	case "csvs":
                $this->strExportType = 'csv';
	    	    $this->strExportDelimiter = ';';
	    		break;
	    	case "excel":
                $this->strExportType = 'excel95';
	    	    $this->strExportDelimiter = ',';
	    		break;
	    	default:
	    		break;
	    }
	    $objExport = VisitorsStatExport::factory($this->strExportType);
	    if ($objExport===false) 
	    {
            echo "<html><body>Driver ".$this->strExportType." not found!</body></html>";
	    	return ;
	    }
   	    $objVisitors = \Database::getInstance()
   	            ->prepare("SELECT 
                                tvc.title AS category_title, 
                                tv.id AS visitors_id, 
                                tv.visitors_name, 
                                tv.published, 
                                tvs.visitors_date, 
                                tvs.visitors_visit, 
                                tvs.visitors_hit
                            FROM 
                                tl_visitors AS tv
                            LEFT JOIN 
                                tl_visitors_counter AS tvs ON (tvs.vid=tv.id)
                            LEFT JOIN 
                                tl_visitors_category AS tvc ON (tvc.id=tv.pid)
                            WHERE 
                                tvc.id = ?
                            ORDER BY tvc.title, tv.id, tvs.visitors_date")
                ->execute($intVisitorKatId);
	    $objExport->export($objVisitors, $this->strExportDelimiter, $intVisitorKatId);
	    exit;
	}
}

/**
 * Instantiate
 */
$objVisitorStatExport = new VisitorsStatExport();
$objVisitorStatExport->run();

