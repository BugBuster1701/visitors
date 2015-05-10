<?php 

/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Visitors Statistik Export - CSV Variante
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
 * Class VisitorsStatExportcsv
 *
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 */
class VisitorsStatExportcsv
{
    protected $ExportLib = 'csv';
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
    
    public function export(\Database $objVisitors,$csv_delimiter,$intVisitorKatId) 
    {
        // Download
        header('Content-Type: text/comma-separated-values');
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="VisitorsStatExport-'.$intVisitorKatId.'.utf8.csv"');
        if ($this->BrowserAgent == 'IE') 
        {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } 
        else 
        {
            header('Pragma: no-cache');
        }
        $csv_enclosure = '"'; 
        //$out = fopen(TL_ROOT . '/' . $GLOBALS['TL_CONFIG']['uploadPath'] . '/BannerStatExport.csv', 'w+');
        $out = fopen('php://output', 'w');
        //Kopfdaten
        $arrVisitorsStat = explode(",",html_entity_decode($GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export_headline'],ENT_NOQUOTES,'UTF-8'));
        fputcsv($out, $arrVisitorsStat, $csv_delimiter, $csv_enclosure);
        unset($arrVisitorsStat);
        //Daten
        while ($objVisitors->next())
        {
            $arrVisitorsStat[] = $objVisitors->category_title;
            $arrVisitorsStat[] = $objVisitors->visitors_id;
    		$arrVisitorsStat[] = $objVisitors->visitors_name;
    		$arrVisitorsStat[] = $objVisitors->published=='' ? $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_no'] : $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_yes'];
    		$arrVisitorsStat[] = date($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($objVisitors->visitors_date));
    		$arrVisitorsStat[] = $objVisitors->visitors_visit;
    		$arrVisitorsStat[] = $objVisitors->visitors_hit;
            fputcsv($out, $arrVisitorsStat, $csv_delimiter, $csv_enclosure);
            unset($arrVisitorsStat);
        }
        fclose($out);
    }
}
