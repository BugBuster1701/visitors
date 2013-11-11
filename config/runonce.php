<?php @error_reporting(0); @ini_set("display_errors", 0);  
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * Modul Visitors - /config/runonce.php
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer
 * @package    GLVisitors
 * @license    LGPL
 */

/**
 * Class VisitorsRunonceJob
 *
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer
 * @package    GLVisitors
 * @license    LGPL
 */
class VisitorsRunonceJob extends Controller
{
	public function __construct()
	{
	    parent::__construct();
	    $this->import('Database');
	}
	
	public function run()
	{
		//nur ab Contao 2.9
		if (version_compare(VERSION, '2.8', '>'))
		{
			$migration = false;
			$addTemplate = false;
			if ($this->Database->tableExists('tl_visitors_category'))
			{
				if ($this->Database->fieldExists('visitors_template', 'tl_visitors_category')
				&& !$this->Database->fieldExists('visitors_template', 'tl_module'))
				{
					//Migration mit Neufeldanlegung
					//Feld anlegen
					$this->Database->execute("ALTER TABLE `tl_module` ADD `visitors_template` varchar(32) NOT NULL default ''");
					$addTemplate = true;
					//Feld versuchen zu fuellen, macht der naechste Abschnitt
				}
				if ( ($this->Database->fieldExists('visitors_template', 'tl_visitors_category')
				   && $this->Database->fieldExists('visitors_template', 'tl_module')) 
				   || $addTemplate === true)
				{
					//Test ob Feld in allen Visitors Modulen leer
					$objTemplates = $this->Database->execute("SELECT count(visitors_template) AS ANZ FROM tl_module WHERE visitors_template !=''");
					while ($objTemplates->next())
					{
						if ($objTemplates->ANZ > 0) 
						{
						    // gefuellt
						    $migration = false;
						} 
						else 
						{
						    $migration = true;
						}
					} // while
					if ($migration == true) 
					{
						//Feld versuchen zu fuellen
						$objVisitorsTemplatesNew = $this->Database->execute("SELECT `id`, `name` , `visitors_categories` FROM `tl_module` WHERE `type`='visitors'");
						while ($objVisitorsTemplatesNew->next())
						{
							if (strpos($objVisitorsTemplatesNew->visitors_categories,':') !== false)
							{
							    $arrKat = deserialize($objVisitorsTemplatesNew->visitors_categories, true);
							} else {
							    $arrKat = array($objVisitorsTemplatesNew->visitors_categories);
							}
							if (count($arrKat) == 1 && (int)$arrKat[0] >0)
							{ //nicht NULL
								//eine eindeutige Zuordnung, kann eindeutig migriert werden
								$objTemplatesOld = $this->Database->execute("SELECT `id`, `title`, `visitors_template` FROM `tl_visitors_category` WHERE id =".$arrKat[0]."");
								while ($objTemplatesOld->next())
								{
									$this->Database->prepare("UPDATE tl_module SET visitors_template=? WHERE id=?")->execute($objTemplatesOld->visitors_template, $objVisitorsTemplatesNew->id);
									//Protokoll
									$strText = 'Visitors-Module "'.$objVisitorsTemplatesNew->name.'" has been migrated';
									$this->Database->prepare("INSERT INTO `tl_log` (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'BE', 'CONFIGURATION', '', specialchars($strText), 'Visitors Modul Template Migration', '127.0.0.1', 'NoBrowser');
								}
							}
							elseif (count($arrKat) > 1) 
							{
								$objTemplatesOld = $this->Database->execute("SELECT `id`, `title`, `visitors_template` FROM `tl_visitors_category` WHERE id =".$arrKat[0]."");
								while ($objTemplatesOld->next())
								{
									$strText = 'Visitors-Module "'.$objVisitorsTemplatesNew->name.'" could not be migrated';
									$this->Database->prepare("INSERT INTO `tl_log` (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'BE', 'CONFIGURATION', '', specialchars($strText), 'Visitors Modul Template Migration', '127.0.0.1', 'NoBrowser');
								}
							}
						}
						$this->Database->execute("UPDATE `tl_visitors_browser` SET `visitors_counter`=0 WHERE `visitors_browser`='Unknown' AND `visitors_os`='Unknown'");
					} // migration == true
				} // if exists or true
				if ($this->Database->tableExists('tl_visitors_searchengines'))
				{
				    //Korrektur 2.1 nach 2.2
				    $this->Database->execute("DELETE FROM `tl_visitors_searchengines` WHERE `visitors_searchengine` = 'Yandex' AND `visitors_keywords`=''");
				    $this->Database->execute("UPDATE `tl_visitors_browser` SET `visitors_counter`=0 WHERE `visitors_browser`='Unknown' AND `visitors_os`='Unknown'");
				}
			}
		} // if >2.8
		else 
		{
			$this->Database->prepare("INSERT INTO `tl_log` (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'FE', 'ERROR', ($GLOBALS['TL_USERNAME'] ? $GLOBALS['TL_USERNAME'] : ''), 'ERROR: Visitors-Module requires at least Contao 2.9', 'ModulVisitors Runonce', '127.0.0.1', 'NoBrowser');
		}
		
		if ($this->Database->tableExists('tl_visitors_browser'))
		{
    		// MacOSX-2-iOS
		    $this->Database->execute("UPDATE `tl_visitors_browser` SET `visitors_os`='iOS' WHERE `visitors_os`='MacOSX' AND `visitors_browser` LIKE 'iPhone%' OR `visitors_browser` LIKE 'iPad%' OR `visitors_browser` LIKE 'iPod%'");
		    // Windows-2-Win8, leider nicht eindeutig.
		    //$this->Database->execute("UPDATE `tl_visitors_browser` SET `visitors_os`='Win8' WHERE `visitors_os`='Windows' AND `visitors_browser` IN ('IE 9.0','IE 10.0')");
		}
		if ($this->Database->tableExists('tl_visitors_referrer'))
		{
		    // Fake Referrer
		    $this->Database->prepare("DELETE FROM `tl_visitors_referrer` WHERE visitors_referrer_dns like ? 
                                      AND ( visitors_referrer_dns = SUBSTRING(visitors_referrer_full,-14)
                                       OR   visitors_referrer_dns = SUBSTRING(visitors_referrer_full,-13)
                                       OR  CONCAT(visitors_referrer_dns,'/') = SUBSTRING(visitors_referrer_full,-14)
                                       OR  CONCAT(visitors_referrer_dns,'/') = SUBSTRING(visitors_referrer_full,-15))")
		                   ->execute('%google%');
		}
		
		// Doppeleintraege eliminieren (2.7.1)
		if ($this->Database->tableExists('tl_visitors_counter'))
		{
		    $objMulti = $this->Database->prepare("SELECT `vid`,`visitors_date`,count( `id` ) as Anzahl
                                                      FROM `tl_visitors_counter`
                                                      GROUP BY 1,2
                                                      HAVING count( `id` ) >1")
		                                ->execute();
		    while ($objMulti->next())
		    {
		        $currentRow = 0;
		        $visits     = 0;
		        $hits       = 0;
		        $realId     = 0;
		        $objMultiRows = $this->Database->prepare("SELECT `id`,`vid`,`visitors_date`,`visitors_visit`, `visitors_hit`
                                                            FROM `tl_visitors_counter`
                                                            WHERE `vid`=? AND `visitors_date`=?
                                                            ORDER BY `visitors_visit` DESC")
                                               ->execute($objMulti->vid, $objMulti->visitors_date);
		        while ($objMultiRows->next())
		        {
		            $currentRow++;
    		        if ($currentRow == 1) 
    		        {
    		            $realId = $objMultiRows->id;
    		        }
    		        else 
    		        {
    		            $objUpdate = $this->Database->prepare("UPDATE `tl_visitors_counter`
    		                                                   SET `visitors_visit`=`visitors_visit`+ ?
    		                                                     , `visitors_hit`  =`visitors_hit`  + ?
    		                                                   WHERE `id`=?")
    		                                        ->execute($objMultiRows->visitors_visit, 
    		                                                  $objMultiRows->visitors_hit, 
    		                                                  $realId);

    		            $objDelete = $this->Database->prepare("DELETE FROM `tl_visitors_counter`
    		                                                   WHERE `id`=?")
    		                                        ->execute($objMultiRows->id);
    		        }
		        } //while $objMultiRows
		    } //while $objMulti
		} //if tl_visitors_counter
		
		// leere Generic eliminieren (Issue #67)
		if ($this->Database->tableExists('tl_visitors_searchengines'))
		{
		    $objDelete = $this->Database->prepare("DELETE FROM `tl_visitors_searchengines`
                                                    WHERE `visitors_searchengine`=? 
                                                    AND `visitors_keywords`=?")
                                        ->execute('Generic','');
		}
	} //function run
} // class

$objVisitorsRunonceJob = new VisitorsRunonceJob();
$objVisitorsRunonceJob->run();

?>