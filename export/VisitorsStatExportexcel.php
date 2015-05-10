<?php 

/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Visitors Statistik Export - Excel Variante
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
 * Class VisitorsStatExportexcel
 *
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 */
class VisitorsStatExportexcel
{
    protected $ExportLib = 'excel';
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
        unset($csv_delimiter);
        // Download
        header('Content-Type: application/vnd.ms-excel');
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Content-Disposition: attachment; filename="VisitorsStatExport-'.$intVisitorKatId.'.utf8.xls"');
        if ($this->BrowserAgent == 'IE') 
        {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } 
        else 
        {
            header('Pragma: no-cache');
        }

        $excel_header = '
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<style id="Classeur1_16681_Styles">
</style>

</head>
<body>

<div id="Classeur1_16681" align=center x:publishsource="Excel">

<table x:str border=0 cellpadding=0 cellspacing=0 width=100% style="border-collapse: collapse">
';
        $excel_footer = '
</table>
</div>
</body>
</html>
';
        $out = fopen('php://output', 'w');
        fputs($out, $excel_header);
        //Kopfdaten
        $arrVisitorsStatHeader = explode(",",html_entity_decode($GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export_headline'],ENT_NOQUOTES,'UTF-8'));
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[0].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[1].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[2].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[3].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[4].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[5].'</b></td>';
        $arrVisitorsStat[] = '<td class=xl2216681 nowrap><b>'.$arrVisitorsStatHeader[6].'</b></td>';
        fputs($out, '<tr>'.implode("",$arrVisitorsStat).'</tr>');

        unset($arrVisitorsStat);
        //Daten
        while ($objVisitors->next())
        {
            $arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.$objVisitors->category_title.'</td>';
            $arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.$objVisitors->visitors_id.'</td>';
    		$arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.$objVisitors->visitors_name.'</td>';
    		$arrVisitorsStat[] = $objVisitors->published=='' ? '<td class=xl2216681 nowrap>'.$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_no'].'</td>' : '<td class=xl2216681 nowrap>'.$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_yes'].'</td>';
    		$arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.date($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($objVisitors->visitors_date)).'</td>';
    		$arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.$objVisitors->visitors_visit.'</td>';
    		$arrVisitorsStat[] = '<td class=xl2216681 nowrap>'.$objVisitors->visitors_hit.'</td>';
    		fputs($out, '<tr>'.implode("",$arrVisitorsStat).'</tr>');

            unset($arrVisitorsStat);
        }
        fputs($out, $excel_footer);
        fclose($out);
    }
}
