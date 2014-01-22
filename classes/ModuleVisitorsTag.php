<?php 

/**
 * Extension for Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 * 
 * Modul Visitors Tag - Frontend for InsertTags
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
 * Class ModuleVisitorsTag 
 *
 * @copyright  Glen Langer 2012..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 * @license    LGPL 
 */
class ModuleVisitorsTag extends \Frontend  
{
	private $_BOT = false;	// Bot
	
	private $_SE  = false;	// Search Engine
	
	private $_PF  = false;	// Prefetch found
	
	private $_VB  = false;	// Visit Blocker
	
	/**
	 * replaceInsertTags
	 * 
	 * From TL 2.8 you can use prefix "cache_". Thus the InserTag will be not cached. (when "cache" is enabled)
	 * 
	 * visitors::katid::name			- VisitorsName
	 * visitors::katid::online			- VisitorsOnlineCount
	 * visitors::katid::start			- VisitorsStartDate
	 * visitors::katid::totalvisit		- TotalVisitCount
	 * visitors::katid::totalhit		- TotalHitCount
	 * visitors::katid::todayvisit		- TodayVisitCount
	 * visitors::katid::todayhit		- TodayHitCount
	 * visitors::katid::averagevisits	- AverageVisits
	 * 
	 * cache_visitors::katid::count		- Counting (only)
	 * 
	 * Not used in the templates:
	 * visitors::katid::bestday::date   - Day (Date) with the most visitors
	 * visitors::katid::bestday::visits - Visits of the day with the most visitors
	 * visitors::katid::bestday::hits   - Hits of the day with the most visitors! (not hits!)
	 * 
	 * @param string $strTag
	 * @return bool / string
	 */
	public function ReplaceInsertTagsVisitors($strTag)
	{
		$arrTag = trimsplit('::', $strTag);
		if ($arrTag[0] != 'visitors')
		{
			if ($arrTag[0] != 'cache_visitors') 
			{
				return false; // nicht für uns
			}
		}
		$this->loadLanguageFile('tl_visitors');
		if (!isset($arrTag[2])) 
		{
			$this->log($GLOBALS['TL_LANG']['tl_visitors']['no_key'], 'ModulVisitors ReplaceInsertTags '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
			return false;  // da fehlt was
		}

		$visitors_category_id = (int)$arrTag[1];

		if ($arrTag[2] == 'count') 
		{
			/* __________  __  ___   _____________   ________
			  / ____/ __ \/ / / / | / /_  __/  _/ | / / ____/
			 / /   / / / / / / /  |/ / / /  / //  |/ / / __  
			/ /___/ /_/ / /_/ / /|  / / / _/ // /|  / /_/ /  
			\____/\____/\____/_/ |_/ /_/ /___/_/ |_/\____/ only
			*/

			$objVisitors = \Database::getInstance()
			        ->prepare("SELECT 
                                    tl_visitors.id AS id, 
                                    visitors_block_time, 
                                    visitors_cache_mode
                                FROM 
                                    tl_visitors 
                                LEFT JOIN 
                                    tl_visitors_category ON (tl_visitors_category.id=tl_visitors.pid)
                                WHERE 
                                    pid=? AND published=?
                                ORDER BY id, visitors_name")
                    ->limit(1)
                    ->executeUncached($visitors_category_id,1);
			if ($objVisitors->numRows < 1)
			{
			    $this->log($GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'], 'ModulVisitors ReplaceInsertTags', TL_ERROR);
				return false;
			}
			while ($objVisitors->next())
			{
			    $this->VisitorCountUpdate($objVisitors->id, $objVisitors->visitors_block_time, $visitors_category_id);
			    $this->VisitorCheckSearchEngine($objVisitors->id);
			    if ($this->_BOT === false && $this->_SE === false) 
			    {
			    	$this->VisitorCheckReferrer($objVisitors->id);
			    }
			}
			//log_message('run BOT SE : '.(int)$this->_BOT . '-' . (int)$this->_SE,'debug.log');
			if ($GLOBALS['TL_CONFIG']['cacheMode'] === 'server' 
			 || $GLOBALS['TL_CONFIG']['cacheMode'] === 'none'
			 || $objVisitors->visitors_cache_mode == 1) 
			{
				return '<!-- counted -->'; // <img src="system/modules/visitors/assets/leer.gif" alt="" /> // style="width:0px; height:0px; visibility:hidden; display:inline; left:-1000px; overflow:hidden; position:absolute; top:-1000px;"
			} 
			else 
			{
				return '<img src="system/modules/visitors/public/ModuleVisitorsCount.php?vkatid='.$visitors_category_id.'" alt="" />'; // style="width:0px; height:0px; visibility:hidden; display:inline; left:-1000px; overflow:hidden; position:absolute; top:-1000px;"
			}
		}
		
		/* ____  __  ____________  __  ________
		  / __ \/ / / /_  __/ __ \/ / / /_  __/
		 / / / / / / / / / / /_/ / / / / / /   
		/ /_/ / /_/ / / / / ____/ /_/ / / /    
		\____/\____/ /_/ /_/    \____/ /_/ 
		*/
		$objVisitors = \Database::getInstance()
		        ->prepare("SELECT 
                                tl_visitors.id AS id, 
                                visitors_name, 
                                visitors_startdate, 
                                visitors_visit_start, 
                                visitors_hit_start, 
                                visitors_average, 
                                visitors_thousands_separator
                            FROM 
                                tl_visitors 
                            LEFT JOIN 
                                tl_visitors_category ON (tl_visitors_category.id=tl_visitors.pid)
                            WHERE 
                                pid=? AND published=?
                            ORDER BY id, visitors_name")
                ->limit(1)
                ->executeUncached($visitors_category_id,1);
		if ($objVisitors->numRows < 1)
		{
		    $this->log($GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'], 'ModulVisitors ReplaceInsertTags '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
			return false;
		}
		$objVisitors->next();
		$boolSeparator = ($objVisitors->visitors_thousands_separator == 1) ? true : false;
		switch ($arrTag[2]) 
		{
		    case "name":
				return trim($objVisitors->visitors_name);
				break;
		    case "online":
				    //VisitorsOnlineCount
				    $objVisitorsOnlineCount = \Database::getInstance()
				            ->prepare("SELECT 
                                            COUNT(id) AS VOC 
                                        FROM 
                                            tl_visitors_blocker
                                        WHERE 
                                            vid=? AND visitors_type=?")
                            ->executeUncached($objVisitors->id,'v');
		            $objVisitorsOnlineCount->next();
		            $VisitorsOnlineCount = ($objVisitorsOnlineCount->VOC === null) ? 0 : $objVisitorsOnlineCount->VOC;
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsOnlineCount,0) : $VisitorsOnlineCount;
				break;
		    case "start":
			    	//VisitorsStartDate
			        if (!strlen($objVisitors->visitors_startdate)) 
			        {
				    	$VisitorsStartDate = '';
				    } 
				    else 
				    {
				        global $objPage;
				        $VisitorsStartDate = $this->parseDate($objPage->dateFormat, $objVisitors->visitors_startdate);
				    }
				return $VisitorsStartDate;
				break;
		    case "totalvisit":
			    	//TotalVisitCount
		            $objVisitorsTotalCount = \Database::getInstance()
		                    ->prepare("SELECT 
                                            SUM(visitors_visit) AS SUMV
                                        FROM 
                                            tl_visitors_counter
                                        WHERE 
                                            vid=?")
                            ->executeUncached($objVisitors->id);
					$VisitorsTotalVisitCount = $objVisitors->visitors_visit_start; //startwert
					if ($objVisitorsTotalCount->numRows > 0) 
					{
		    		    $objVisitorsTotalCount->next();
		                $VisitorsTotalVisitCount += ($objVisitorsTotalCount->SUMV === null) ? 0 : $objVisitorsTotalCount->SUMV;
				    }
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsTotalVisitCount,0) : $VisitorsTotalVisitCount;
				break;
		    case "totalhit":
		    		//TotalHitCount
		            $objVisitorsTotalCount = \Database::getInstance()
		                    ->prepare("SELECT 
                                            SUM(visitors_hit) AS SUMH
                                        FROM 
                                            tl_visitors_counter
                                        WHERE 
                                            vid=?")
                            ->executeUncached($objVisitors->id);
					$VisitorsTotalHitCount   = $objVisitors->visitors_hit_start;   //startwert
					if ($objVisitorsTotalCount->numRows > 0) 
					{
		    		    $objVisitorsTotalCount->next();
		                $VisitorsTotalHitCount += ($objVisitorsTotalCount->SUMH === null) ? 0 : $objVisitorsTotalCount->SUMH;
				    }
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsTotalHitCount,0) : $VisitorsTotalHitCount;
				break;
		    case "todayvisit":
					//TodaysVisitCount
				    $objVisitorsTodaysCount = \Database::getInstance()
				            ->prepare("SELECT 
                                            visitors_visit
                                        FROM 
                                            tl_visitors_counter
                                        WHERE 
                                            vid=? AND visitors_date=?")
                            ->executeUncached($objVisitors->id,date('Y-m-d'));
				    if ($objVisitorsTodaysCount->numRows < 1) 
				    {
				    	$VisitorsTodaysVisitCount = 0;
				    } 
				    else 
				    {
		    		    $objVisitorsTodaysCount->next();
		    		    $VisitorsTodaysVisitCount = ($objVisitorsTodaysCount->visitors_visit === null) ? 0 : $objVisitorsTodaysCount->visitors_visit;
				    }
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsTodaysVisitCount,0) : $VisitorsTodaysVisitCount;
				break;
		    case "todayhit":
					//TodaysHitCount
				    $objVisitorsTodaysCount = \Database::getInstance()
				            ->prepare("SELECT 
                                            visitors_hit
                                        FROM 
                                            tl_visitors_counter
                                        WHERE 
                                            vid=? AND visitors_date=?")
                            ->executeUncached($objVisitors->id,date('Y-m-d'));
				    if ($objVisitorsTodaysCount->numRows < 1) 
				    {
				    	$VisitorsTodaysHitCount   = 0;
				    } 
				    else 
				    {
		    		    $objVisitorsTodaysCount->next();
		    		    $VisitorsTodaysHitCount   = ($objVisitorsTodaysCount->visitors_hit   === null) ? 0 : $objVisitorsTodaysCount->visitors_hit;
				    }
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsTodaysHitCount,0) : $VisitorsTodaysHitCount;
				break;
		    case "averagevisits":
					// Average Visits
				    if ($objVisitors->visitors_average) 
				    {
				    	$today     = date('Y-m-d');
						$yesterday = date('Y-m-d',mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
		                $objVisitorsAverageCount = \Database::getInstance()
		                        ->prepare("SELECT 
                                                SUM(visitors_visit)  AS SUMV, 
                                                MIN( visitors_date ) AS MINDAY
                                            FROM 
                                                tl_visitors_counter
                                            WHERE 
                                                vid=? AND visitors_date<?")
                                ->executeUncached($objVisitors->id,$today);
		    		    if ($objVisitorsAverageCount->numRows > 0) 
		    		    {
		                    $objVisitorsAverageCount->next();
		                    $tmpTotalDays = floor( (strtotime($yesterday) - strtotime($objVisitorsAverageCount->MINDAY))/60/60/24 );
		                    $VisitorsAverageVisitCount = ($objVisitorsAverageCount->SUMV === null) ? 0 : $objVisitorsAverageCount->SUMV;
		                    if ($tmpTotalDays > 0) 
		                    {
		                    	$VisitorsAverageVisits = round($VisitorsAverageVisitCount / $tmpTotalDays , 0);
		                    } 
		                    else 
		                    {
		                    	$VisitorsAverageVisits = 0;
		                    }
		                }
				    } 
				    else 
				    {
		                $VisitorsAverageVisits = 0;
		            }
				return ($boolSeparator) ? $this->getFormattedNumber($VisitorsAverageVisits,0) : $VisitorsAverageVisits;
				break;
		    case "bestday":
		    	//Day with the most visitors
		    	if (!isset($arrTag[3])) 
		    	{
					$this->log($GLOBALS['TL_LANG']['tl_visitors']['no_param4'], 'ModulVisitors ReplaceInsertTags '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
					return false;  // da fehlt was
				}
				$objVisitorsBestday = \Database::getInstance()
				        ->prepare("SELECT 
                                        visitors_date, 
                                        visitors_visit, 
                                        visitors_hit
                                    FROM 
                                        tl_visitors_counter
                                    WHERE 
                                        vid=?
                                    ORDER BY visitors_visit DESC, visitors_hit DESC")
                        ->limit(1)
                        ->execute($objVisitors->id);
				if ($objVisitorsBestday->numRows > 0) 
				{
		        	$objVisitorsBestday->next();
				}
				switch ($arrTag[3]) 
				{
					case "date":
						if (!isset($arrTag[4])) 
						{
							return date($GLOBALS['TL_CONFIG']['dateFormat'],strtotime($objVisitorsBestday->visitors_date));
						} 
						else 
						{
							return date($arrTag[4],strtotime($objVisitorsBestday->visitors_date));
						}
						break;
					case "visits":
						return ($boolSeparator) ? $this->getFormattedNumber($objVisitorsBestday->visitors_visit,0) : $objVisitorsBestday->visitors_visit;
						break;
					case "hits":
						return ($boolSeparator) ? $this->getFormattedNumber($objVisitorsBestday->visitors_hit,0) : $objVisitorsBestday->visitors_hit;
						break;
					default:
						return false;
						break;
				}
		    	break;
			default:
				$this->log($GLOBALS['TL_LANG']['tl_visitors']['wrong_key'], 'ModulVisitors ReplaceInsertTags '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
				return false;
				break;
		}
	} //function
	
	/**
	 * Insert/Update Counter
	 */
	protected function VisitorCountUpdate($vid, $BlockTime, $visitors_category_id)
	{
		$ModuleVisitorChecks = new \Visitors\ModuleVisitorChecks();
		if (!isset($GLOBALS['TL_CONFIG']['mod_visitors_bot_check']) || $GLOBALS['TL_CONFIG']['mod_visitors_bot_check'] !== false) 
		{
			if ($ModuleVisitorChecks->CheckBot() == true) 
			{
				$this->_BOT = true;
		    	return; //Bot / IP gefunden, wird nicht gezaehlt
		    }
		}
	    if ($ModuleVisitorChecks->CheckUserAgent($visitors_category_id) == true) 
	    {
	    	$this->_PF = true; // Bad but functionally
	    	return ; //User Agent Filterung
	    }
	    //log_message("VisitorCountUpdate count: ".$this->Environment->httpUserAgent,"useragents-noblock.log");
	    $ClientIP = bin2hex(sha1($visitors_category_id . \Environment::get('ip'),true)); // sha1 20 Zeichen, bin2hex 40 zeichen
	    $BlockTime = ($BlockTime == '') ? 1800 : $BlockTime; //Sekunden
	    $CURDATE = date('Y-m-d');
	    //Visitor Blocker
	    \Database::getInstance()
	            ->prepare("DELETE FROM 
                                tl_visitors_blocker
                            WHERE 
                                CURRENT_TIMESTAMP - INTERVAL ? SECOND > visitors_tstamp
                                AND vid = ? 
                                AND visitors_type = ?")
                ->executeUncached($BlockTime, $vid, 'v');

	    //Hit Blocker for IE8 Bullshit and Browser Counting
	    \Database::getInstance()
	            ->prepare("DELETE FROM 
                                tl_visitors_blocker
                            WHERE 
                                CURRENT_TIMESTAMP - INTERVAL ? SECOND > visitors_tstamp
                                AND vid = ? 
                                AND visitors_type = ?")
                ->executeUncached(3, $vid, 'h'); // 3 Sekunden Blockierung zw. Zählung per Tag und Zählung per Browser
	    if ($ModuleVisitorChecks->CheckBE() == true) 
	    {
	    	$this->_PF = true; // Bad but functionally
			return; // Backend eingeloggt, nicht zaehlen (Feature: #197)
		}
		
		//Test ob Hits gesetzt werden muessen (IE8 Bullshit and Browser Counting)
		$objHitIP = \Database::getInstance()
		        ->prepare("SELECT 
                                id, 
                                visitors_ip
                            FROM 
                                tl_visitors_blocker
                            WHERE 
                                visitors_ip = ?
                                AND vid = ? 
                                AND visitors_type = ?")
                ->executeUncached($ClientIP, $vid, 'h');
				
	    //Hits und Visits lesen
	    $objHitCounter = \Database::getInstance()
	            ->prepare("SELECT 
                                id, 
                                visitors_hit, 
                                visitors_visit
                            FROM 
                                tl_visitors_counter
                            WHERE 
                                visitors_date = ? AND vid = ?")
                ->executeUncached($CURDATE, $vid);
        //Hits setzen
	    if ($objHitCounter->numRows < 1) 
	    {
	    	if ($objHitIP->numRows < 1) 
	    	{
	    	    //at first: block
	    	    \Database::getInstance()
	    	            ->prepare("INSERT INTO 
                                        tl_visitors_blocker
                                    SET 
                                        vid = ?, 
                                        visitors_tstamp=CURRENT_TIMESTAMP, 
                                        visitors_ip = ?, 
                                        visitors_type = ?")
                        ->execute($vid, $ClientIP, 'h');
		        // Insert
		        $arrSet = array
	            (
	                'vid'               => $vid,
	                'visitors_date'     => $CURDATE,
	                'visitors_visit'    => 1,
	                'visitors_hit'      => 1
	            ); 
			    \Database::getInstance()
			            ->prepare("INSERT IGNORE INTO tl_visitors_counter %s")
                        ->set($arrSet)
                        ->executeUncached();
	    	} 
	    	else 
	    	{
	    		$this->_PF = true; // Prefetch found
	    	}
		    $visitors_hits=1;
		    $visitors_visit=1;
	    } 
	    else 
	    {
	        $objHitCounter->next();
	        $visitors_hits = $objHitCounter->visitors_hit +1;
	        $visitors_visit= $objHitCounter->visitors_visit +1; 
			if ($objHitIP->numRows < 1) 
			{
		        // Update
		    	\Database::getInstance()
		    	        ->prepare("INSERT INTO 
                                        tl_visitors_blocker
                                    SET 
                                        vid = ?, 
                                        visitors_tstamp=CURRENT_TIMESTAMP, 
                                        visitors_ip = ?, 
                                        visitors_type = ?")
                        ->execute($vid, $ClientIP, 'h');
		    	\Database::getInstance()
		    	        ->prepare("UPDATE 
                                        tl_visitors_counter 
                                    SET 
                                        visitors_hit=? 
                                    WHERE 
                                        id=?")
                        ->executeUncached($visitors_hits, $objHitCounter->id);
			} 
			else 
			{
	    		$this->_PF = true; // Prefetch found
	    	}
	    }
	    
	    //Visits / IP setzen
	    $objVisitIP = \Database::getInstance()
	            ->prepare("SELECT 
                                id, 
                                visitors_ip
                            FROM 
                                tl_visitors_blocker
                            WHERE 
                                visitors_ip = ? AND vid = ? AND visitors_type = ?")
                ->executeUncached($ClientIP, $vid, 'v');
	    if ($objVisitIP->numRows < 1) 
	    {
	        // not blocked: Insert IP + Update Visits
	        \Database::getInstance()
	                ->prepare("INSERT INTO 
                                    tl_visitors_blocker
                                SET 
                                    vid = ?, 
                                    visitors_tstamp = CURRENT_TIMESTAMP, 
                                    visitors_ip = ?, 
                                    visitors_type = ?")
                    ->execute($vid, $ClientIP, 'v');
	        
	        \Database::getInstance()
	                ->prepare("UPDATE 
                                    tl_visitors_counter 
                                SET 
                                    visitors_visit = ?
                                WHERE 
                                    visitors_date = ? AND vid = ?")
                    ->executeUncached($visitors_visit, $CURDATE, $vid);
	    } 
	    else 
	    {
	    	// blocked: Update tstamp
	    	\Database::getInstance()
	    	        ->prepare("UPDATE 
                                    tl_visitors_blocker
                                SET 
                                    visitors_tstamp = CURRENT_TIMESTAMP
                                WHERE 
                                    visitors_ip = ?
                                    AND vid = ? 
                                    AND visitors_type = ?")
                    ->executeUncached($ClientIP, $vid, 'v');
	    	$this->_VB = true;
	    }
	    if ($objVisitIP->numRows < 1) 
	    { //Browser Check wenn nicht geblockt
		    //Only counting if User Agent is set.
		    if ( strlen(\Environment::get('httpUserAgent'))>0 ) 
		    {
			    /* Variante 3 */
				$ModuleVisitorBrowser3 = new \Visitors\ModuleVisitorBrowser3();
				$ModuleVisitorBrowser3->initBrowser(\Environment::get('httpUserAgent'),implode(",", \Environment::get('httpAcceptLanguage')));
				if ($ModuleVisitorBrowser3->getLang() === null) 
				{
					log_message("ModuleVisitorBrowser3 Systemerror","error.log");
			    	$this->log("ModuleVisitorBrowser3 Systemerror",'ModulVisitors', TL_ERROR);
				} 
				else 
				{
					$arrBrowser['Browser']  = $ModuleVisitorBrowser3->getBrowser();
					$arrBrowser['Version']  = $ModuleVisitorBrowser3->getVersion();
					$arrBrowser['Platform'] = $ModuleVisitorBrowser3->getPlatformVersion();
					$arrBrowser['lang']     = $ModuleVisitorBrowser3->getLang();
				    //Anpassen an Version 1 zur Weiterverarbeitung
				    if ($arrBrowser['Browser'] == 'unknown') 
				    {
				    	$arrBrowser['Browser'] = 'Unknown';
				    }
				    if ($arrBrowser['Version'] == 'unknown') 
				    {
				    	$arrBrowser['brversion'] = $arrBrowser['Browser'];
				    } 
				    else 
				    {
				    	$arrBrowser['brversion'] = $arrBrowser['Browser'] . ' ' . $arrBrowser['Version'];
				    }
				    if ($arrBrowser['Platform'] == 'unknown') 
				    {
				    	$arrBrowser['Platform'] = 'Unknown';
				    }
				    //if ( $arrBrowser['Platform'] == 'Unknown' || $arrBrowser['Platform'] == 'Mozilla' || $arrBrowser['Version'] == 'unknown' ) {
				    //	log_message("Unbekannter User Agent: ".$this->Environment->httpUserAgent."", 'unknown.log');
				    //}
				    $objBrowserCounter = \Database::getInstance()
				            ->prepare("SELECT 
                                            id,
                                            visitors_counter
                                        FROM 
                                            tl_visitors_browser
                                        WHERE 
                                            vid = ? 
                                            AND visitors_browser = ?
                                            AND visitors_os = ?
                                            AND visitors_lang = ?")
                            ->executeUncached($vid, $arrBrowser['brversion'], $arrBrowser['Platform'], $arrBrowser['lang']);
				    //setzen
				    if ($objBrowserCounter->numRows < 1) 
				    {
				        // Insert
				        $arrSet = array
			            (
			                'vid'               => $vid,
			                'visitors_browser'  => $arrBrowser['brversion'], // version
			                'visitors_os'		=> $arrBrowser['Platform'],  // os
			                'visitors_lang'		=> $arrBrowser['lang'],
			                'visitors_counter'  => 1
			            );
					    \Database::getInstance()
					            ->prepare("INSERT INTO tl_visitors_browser %s")
                                ->set($arrSet)
                                ->execute();
				    } 
				    else 
				    {
				    	//Update
				        $objBrowserCounter->next();
				        $visitors_counter = $objBrowserCounter->visitors_counter +1;
				    	// Update
				    	\Database::getInstance()
                                ->prepare("UPDATE tl_visitors_browser SET visitors_counter=? WHERE id=?")
                                ->executeUncached($visitors_counter, $objBrowserCounter->id);
				    }
			    } // else von NULL
			} // if strlen
	    } //VisitIP numRows
	} //VisitorCountUpdate
	
	protected function VisitorCheckSearchEngine($vid)
	{
		//$SearchEngine = 'unknown';
		//$Keywords     = 'unknown';
		$ModuleVisitorSearchEngine = new \Visitors\ModuleVisitorSearchEngine();
		$ModuleVisitorSearchEngine->checkEngines();
		$SearchEngine = $ModuleVisitorSearchEngine->getEngine();
		$Keywords     = $ModuleVisitorSearchEngine->getKeywords();
		if ($SearchEngine !== 'unknown') 
		{
			$this->_SE = true;
			if ($Keywords !== 'unknown') 
			{
				// Insert
		        $arrSet = array
		        (
		            'vid'                   => $vid,
		            'tstamp'                => time(),
		            'visitors_searchengine' => $SearchEngine,
		            'visitors_keywords'		=> $Keywords
		        );
			    \Database::getInstance()
			            ->prepare("INSERT INTO tl_visitors_searchengines %s")
                        ->set($arrSet)
                        ->executeUncached();
			    // Delete old entries
			    $CleanTime = mktime(0, 0, 0, date("m")-3, date("d"), date("Y")); // Einträge >= 90 Tage werden gelöscht
			    \Database::getInstance()
			            ->prepare("DELETE FROM tl_visitors_searchengines WHERE tstamp < ? AND vid = ?")
                        ->execute($CleanTime,$vid);
			} //keywords
		} //searchengine
		//log_message('VisitorCheckSearchEngine $SearchEngine: ' . $SearchEngine,'debug.log');
	} //VisitorCheckSearchEngine
	
	/**
	 * Check for Referrer
	 *
	 * @param integer $vid	Visitors ID
	 */
	protected function VisitorCheckReferrer($vid)
	{
		if ($this->_VB === false) 
		{
			if ($this->_PF === false) 
			{
				$ModuleVisitorReferrer = new \Visitors\ModuleVisitorReferrer();
				$ModuleVisitorReferrer->checkReferrer();
				$ReferrerDNS = $ModuleVisitorReferrer->getReferrerDNS();
				$ReferrerFull= $ModuleVisitorReferrer->getReferrerFull();
				//log_message('VisitorCheckReferrer $ReferrerDNS:'.print_r($ReferrerDNS,true), 'debug.log');
				//log_message('VisitorCheckReferrer Host:'.print_r($this->ModuleVisitorReferrer->getHost(),true), 'debug.log');
				if ($ReferrerDNS != 'o' && $ReferrerDNS != 'w') 
				{ 	// not the own, not wrong
					// Insert
			        $arrSet = array
			        (
			            'vid'                   => $vid,
			            'tstamp'                => time(),
			            'visitors_referrer_dns' => $ReferrerDNS,
			            'visitors_referrer_full'=> $ReferrerFull
			        );
			        //Referrer setzen
			    	//log_message('VisitorCheckReferrer Referrer setzen', 'debug.log');
			        \Database::getInstance()
			                ->prepare("INSERT INTO tl_visitors_referrer %s")
                            ->set($arrSet)
                            ->executeUncached();
				    // Delete old entries
				    $CleanTime = mktime(0, 0, 0, date("m")-4, date("d"), date("Y")); // Einträge >= 120 Tage werden gelöscht
				    \Database::getInstance()
                            ->prepare("DELETE FROM tl_visitors_referrer WHERE tstamp < ? AND vid = ?")
                            ->execute($CleanTime, $vid);
		    	}
		    } //if PF
	    } //if VB
	} // VisitorCheckReferrer
	
} // class

