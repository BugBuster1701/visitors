<?php 

/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Visitors Statistik Export - Excel 95 Variante
 *
 * wird von VisitorsStatExport.php aufgerufen als popup
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
 * Class VisitorsStatExportexcel95
 *
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 */
class VisitorsStatExportexcel95
{
    protected $ExportLib = 'excel95';
    protected $BrowserAgent ='';
    
    /**
	 * Constructor
	 */
	public function __construct()
	{
	    //IE or other?
	    $log_version ='';
        $HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");
        if (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) 
        {
            $this->BrowserAgent = 'IE';
        } 
        else 
        {
            $this->BrowserAgent = 'NOIE';
        }
	}
	
    public function getLibName() 
    {
        return $this->ExportLib;
    }
    
    public function export($objVisitors,$csv_delimiter,$intVisitorKatId) 
    {
    	if (file_exists(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php")) 
    	{
	    	include(TL_ROOT . "/system/modules/xls_export/vendor/xls_export.php");
			$xls = new \xlsexport();
			$sheet = 'VisitorsStatExport-'.$intVisitorKatId.'';
			$xls->addworksheet($sheet);
	        //Kopfdaten
	        $arrVisitorsStatHeader = explode(",",html_entity_decode($GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export_headline'],ENT_NOQUOTES,'UTF-8'));
	        
			$intRowCounter = 1;
			for ($c = 1; $c <= 7; $c++)
			{
				$xls->setcolwidth ($sheet,$c-1,0x1000);
				$xls->setcell(array("sheetname" => $sheet,"row" => 0, "col" => $c-1, 'fontweight' => XLSFONT_BOLD, 'hallign' => XLSXF_HALLIGN_CENTER, "data" => utf8_decode($arrVisitorsStatHeader[$c-1])));
			}
	        while ($objVisitors->next())
	        {
	        	$arrVisitorsStat[0] = utf8_decode($objVisitors->category_title);
	            $arrVisitorsStat[1] = $objVisitors->visitors_id;
	    		$arrVisitorsStat[2] = utf8_decode($objVisitors->visitors_name);
	    		$arrVisitorsStat[3] = $objVisitors->published=='' ? $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_no'] : $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_yes'];
	    		$arrVisitorsStat[4] = date($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($objVisitors->visitors_date));
	    		$arrVisitorsStat[5] = $objVisitors->visitors_visit=='' ? '0' : $objVisitors->visitors_visit;
	    		$arrVisitorsStat[6] = $objVisitors->visitors_hit=='' ? '0' : $objVisitors->visitors_hit;
	    		
	        	for ($c = 1; $c <= 7; $c++) 
	        	{
	        		$xls->setcell(array("sheetname" => $sheet,"row" => $intRowCounter, "col" => $c-1, 'hallign' => XLSXF_HALLIGN_CENTER, "data" => $arrVisitorsStat[$c-1]));
	        	}
	        	$intRowCounter++;
	        } // while
			$xls->sendFile($sheet . ".xls");
		} 
		else 
		{
			echo "<html><head><title>Need extension xls_export</title></head><body>"
			    ."Please install the extension 'xls_export' 3.x.<br /><br />"
			    ."Bitte die Erweiterung 'xls_export' 3.x installieren.<br /><br />"
			    ."Installer l'extension 'xls_export' 3.x s'il vous plaît."
			    ."</body></html>";
		}
    }
}
