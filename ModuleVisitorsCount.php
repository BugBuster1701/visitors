<?php
/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Count - Frontend for Counting
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2011
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require(dirname(dirname(dirname(__FILE__))).'/initialize.php');

/**
 * Class ModuleVisitorsCount 
 *
 * @copyright  Glen Langer 2011
 * @author     Glen Langer 
 * @package    GLVisitors
 * @license    LGPL 
 */
class ModuleVisitorsCount extends Frontend  
{
	private $_BOT = false; // Bot
	
	private $_SE  = false; // Search Engine
	
	private $_PF  = false; // Prefetch found
	
	private $_VB  = false;	// Visit Blocker
	
	/**
	 * Initialize object 
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function run()
	{
		require_once(TL_ROOT . '/system/modules/visitors/ModuleVisitorVersion.php');
		//Parameter holen
		if ((int)$this->Input->get('vkatid')>0) {
			$visitors_category_id = (int)$this->Input->get('vkatid');
			$this->import('Database');
			/* __________  __  ___   _____________   ________
			  / ____/ __ \/ / / / | / /_  __/  _/ | / / ____/
			 / /   / / / / / / /  |/ / / /  / //  |/ / / __  
			/ /___/ /_/ / /_/ / /|  / / / _/ // /|  / /_/ /  
			\____/\____/\____/_/ |_/ /_/ /___/_/ |_/\____/ only
			*/
			$objVisitors = $this->Database->prepare("SELECT tl_visitors.id AS id, visitors_block_time"
			                                      ." FROM tl_visitors LEFT JOIN tl_visitors_category ON (tl_visitors_category.id=tl_visitors.pid)"
			                                      ." WHERE pid=? AND published=?" 
			                                      ." ORDER BY id, visitors_name")
			                              ->limit(1)
									      ->executeUncached($visitors_category_id,1);
			if ($objVisitors->numRows < 1) {
			    $this->log($GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'], 'ModulVisitors ReplaceInsertTags '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
			} else {
				while ($objVisitors->next()) {
				    $this->VisitorCountUpdate($objVisitors->id, $objVisitors->visitors_block_time, $visitors_category_id);
				    $this->VisitorCheckSearchEngine($objVisitors->id);
				    if ($this->_BOT === false && $this->_SE === false) {
				    	$this->VisitorCheckReferrer($objVisitors->id);
				    }
				}
			}
		} else {
			$this->log($GLOBALS['TL_LANG']['tl_visitors']['wrong_count_katid'], 'ModulVisitorsCount '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
		}
		//Pixel und raus hier
		header('Cache-Control: no-cache');
		header('Content-type: image/gif');
		header('Content-length: 43');

		echo base64_decode('R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
	} //function
	
	/**
	 * Insert/Update Counter
	 */
	protected function VisitorCountUpdate($vid, $BlockTime, $visitors_category_id)
	{
		$this->import('ModuleVisitorChecks');
		if ($this->ModuleVisitorChecks->CheckBot() == true) {
			$this->_BOT = true;
	    	return; //Bot / IP gefunden, wird nicht gezaehlt
	    }
	    if ($this->ModuleVisitorChecks->CheckUserAgent($visitors_category_id) == true) {
	    	$this->_PF = true; // Bad but functionally
	    	return ; //User Agent Filterung
	    }
	    //log_message("VisitorCountUpdate count: ".$this->Environment->httpUserAgent,"useragents-noblock.log");
	    $ClientIP = bin2hex(sha1($visitors_category_id . $this->Environment->remoteAddr,true)); // sha1 20 Zeichen, bin2hex 40 zeichen
	    $BlockTime = ($BlockTime == '') ? 1800 : $BlockTime; //Sekunden
	    $CURDATE = date('Y-m-d');
	    //Visitor Blocker
	    $this->Database->prepare("DELETE FROM tl_visitors_blocker"
	                           ." WHERE CURRENT_TIMESTAMP - INTERVAL ? SECOND > visitors_tstamp"
	                           ." AND vid=? AND visitors_type=?")
	                   ->executeUncached($BlockTime, $vid, 'v');
	    //Hit Blocker for IE8 Bullshit
	    $this->Database->prepare("DELETE FROM tl_visitors_blocker"
	                           ." WHERE CURRENT_TIMESTAMP - INTERVAL ? SECOND > visitors_tstamp"
	                           ." AND vid=? AND visitors_type=?")
	                   ->executeUncached(3, $vid, 'h');
	    if ($this->ModuleVisitorChecks->CheckBE() == true) {
	    	$this->_PF = true; // Bad but functionally
			return; // Backend eingeloggt, nicht zaehlen (Feature: #197)
		}
		
	    //Hits und Visits lesen
	    $objHitCounter = $this->Database->prepare("SELECT id, visitors_hit, visitors_visit"
	                                            ." FROM tl_visitors_counter"
	                                            ." WHERE visitors_date=?"
	                                            ." AND vid=?")
	                                    ->executeUncached($CURDATE, $vid);
	    //Test ob Hits gesetzt werden muessen (IE8 Bullshit)
	    $objHitIP = $this->Database->prepare("SELECT id, visitors_ip"
                                     ." FROM tl_visitors_blocker"
                                     ." WHERE visitors_ip=?"
                                     ." AND vid=? AND visitors_type=?")
                             	   ->executeUncached($ClientIP, $vid, 'h');
        //Hits setzen
	    if ($objHitCounter->numRows < 1) {
	    	if ($objHitIP->numRows < 1) {
		        // Insert
		        $arrSet = array
	            (
	                'vid'               => $vid,
	                'visitors_date'     => $CURDATE,
	                'visitors_visit'    => 1,
	                'visitors_hit'      => 1
	            );
			    $this->Database->prepare("INSERT INTO tl_visitors_counter %s")->set($arrSet)->executeUncached();
    	        $this->Database->prepare("INSERT INTO tl_visitors_blocker"
				                       ." SET vid=?, visitors_tstamp=CURRENT_TIMESTAMP, visitors_ip=?, visitors_type=?")
				               ->executeUncached($vid, $ClientIP, 'h');
	    	} else {
	    		$this->_PF = true;
	    	}
		    $visitors_hits=1;
		    $visitors_visit=1;
	    } else {
	        $objHitCounter->next();
	        $visitors_hits = $objHitCounter->visitors_hit +1;
	        $visitors_visit= $objHitCounter->visitors_visit +1; // wird nur gesetzt wenn auch neuer Besucher
			if ($objHitIP->numRows < 1) {
		        // Update
		    	$this->Database->prepare("UPDATE tl_visitors_counter SET visitors_hit=? WHERE id=?")
		    	               ->executeUncached($visitors_hits, $objHitCounter->id);
		    	$this->Database->prepare("INSERT INTO tl_visitors_blocker"
				                       ." SET vid=?, visitors_tstamp=CURRENT_TIMESTAMP, visitors_ip=?, visitors_type=?")
				               ->executeUncached($vid, $ClientIP, 'h');
			} else {
	    		$this->_PF = true;
	    	}
	    }
	    
	    //Visits / IP setzen
	    $objVisitIP = $this->Database->prepare("SELECT id, visitors_ip"
	                                         ." FROM tl_visitors_blocker"
	                                         ." WHERE visitors_ip=?"
	                                         ." AND vid=? AND visitors_type=?")
	                                 ->executeUncached($ClientIP, $vid, 'v');
	    if ($objVisitIP->numRows < 1) {
	        // Insert IP + Update Visits
	        $this->Database->prepare("INSERT INTO tl_visitors_blocker"
	                               ." SET vid=?, visitors_tstamp=CURRENT_TIMESTAMP, visitors_ip=?, visitors_type=?")
	                       ->executeUncached($vid, $ClientIP, 'v');
	        $this->Database->prepare("UPDATE tl_visitors_counter SET visitors_visit=?"
	                               ." WHERE visitors_date=?"
	                               ." AND vid=?")
	    	               ->executeUncached($visitors_visit, $CURDATE, $vid);
	    } else {
	    	// Update tstamp
	    	$this->Database->prepare("UPDATE tl_visitors_blocker"
	    	                       ." SET visitors_tstamp=CURRENT_TIMESTAMP"
	    	                       ." WHERE visitors_ip=?"
	    	                       ." AND vid=? AND visitors_type=?")
	    	               ->executeUncached($ClientIP, $vid, 'v');
	    	$this->_VB = true;
	    }
	    if ($objVisitIP->numRows < 1) { //Browser Check wenn nicht geblockt
		    //Only counting if User Agent is set.
		    if ( strlen($this->Environment->httpUserAgent)>0 ) {
			    /* Variante 2 */
			    /*
			    $this->import('ModuleVisitorBrowser2');
			    $arrBrowser = $this->ModuleVisitorBrowser2->getBrowser($this->Environment->httpUserAgent, true, implode(",", $this->Environment->httpAcceptLanguage));
			    if (count($arrBrowser) === 0) {
			    	log_message("ModuleVisitorBrowser2 Systemerror browscap.ini cache.php","error.log");
			    	$this->log("ModuleVisitorBrowser2 Systemerror browscap.ini cache.php",'ModulVisitors Update '. VISITORS_VERSION .'.'. VISITORS_BUILD, TL_ERROR);
			    } 
			    */
			    /* Variante 3 */
			    $this->import('ModuleVisitorBrowser3');
				$this->ModuleVisitorBrowser3->initBrowser($this->Environment->httpUserAgent,implode(",", $this->Environment->httpAcceptLanguage));
				if ($this->ModuleVisitorBrowser3->getLang() === null) {
					log_message("ModuleVisitorBrowser3 Systemerror","error.log");
			    	$this->log("ModuleVisitorBrowser3 Systemerror",'ModulVisitors', TL_ERROR);
			    } else {
			    	$arrBrowser['Browser']  = $this->ModuleVisitorBrowser3->getBrowser();
					$arrBrowser['Version']  = $this->ModuleVisitorBrowser3->getVersion();
					$arrBrowser['Platform'] = $this->ModuleVisitorBrowser3->getPlatformVersion();
					$arrBrowser['lang']     = $this->ModuleVisitorBrowser3->getLang();
				    //Anpassen an Version 1 zur Weiterverarbeitung
				    if ($arrBrowser['Browser'] == 'unknown') {
				    	$arrBrowser['Browser'] = 'Unknown';
				    }
				    if ($arrBrowser['Version'] == 'unknown') {
				    	$arrBrowser['brversion'] = $arrBrowser['Browser'];
				    } else {
				    	$arrBrowser['brversion'] = $arrBrowser['Browser'] . ' ' . $arrBrowser['Version'];
				    }
				    if ($arrBrowser['Platform'] == 'unknown') {
				    	$arrBrowser['Platform'] = 'Unknown';
				    }
				    //if ( $arrBrowser['Platform'] == 'Unknown' || $arrBrowser['Platform'] == 'Mozilla' || $arrBrowser['Version'] == '0' ) {
				    //	log_message("Unbekannter User Agent: ".$this->Environment->httpUserAgent."", 'unknown.log');
				    //}
				    $objBrowserCounter = $this->Database->prepare("SELECT id,visitors_counter"
					                                            ." FROM tl_visitors_browser"
					                                            ." WHERE vid=?"
					                                            ." AND visitors_browser=?"
					                                            ." AND visitors_os=?"
					                                            ." AND visitors_lang=?"
					                                            )
				                                    	->executeUncached($vid, $arrBrowser['brversion'], $arrBrowser['Platform'], $arrBrowser['lang']);
				    //setzen
				    if ($objBrowserCounter->numRows < 1) {
				        // Insert
				        $arrSet = array
			            (
			                'vid'               => $vid,
			                'visitors_browser'  => $arrBrowser['brversion'], // version
			                'visitors_os'		=> $arrBrowser['Platform'],  // os
			                'visitors_lang'		=> $arrBrowser['lang'],
			                'visitors_counter'  => 1
			            );
					    $this->Database->prepare("INSERT INTO tl_visitors_browser %s")->set($arrSet)->executeUncached();
				    } else {
				    	//Update
				        $objBrowserCounter->next();
				        $visitors_counter = $objBrowserCounter->visitors_counter +1;
				    	// Update
				    	$this->Database->prepare("UPDATE tl_visitors_browser SET visitors_counter=? WHERE id=?")
				    	               ->executeUncached($visitors_counter, $objBrowserCounter->id);
				    }
			    } // else von NULL
			} // if strlen
	    } //VisitIP numRows
	} //VisitorCountUpdate
	
	/**
	 * Check for Searchengines
	 *
	 * @param integer $vid	Visitors ID
	 */
	protected function VisitorCheckSearchEngine($vid)
	{
		//$SearchEngine = 'unknown';
		//$Keywords     = 'unknown';
		$this->import('ModuleVisitorSearchEngine');
		$this->ModuleVisitorSearchEngine->checkEngines();
		$SearchEngine = $this->ModuleVisitorSearchEngine->getEngine();
		$Keywords = $this->ModuleVisitorSearchEngine->getKeywords();
		if ($SearchEngine !== 'unknown') 
		{
			$this->_SE = true;
			if ($Keywords !== 'unknown') {
				// Insert
		        $arrSet = array
		        (
		            'vid'                   => $vid,
		            'tstamp'                => time(),
		            'visitors_searchengine' => $SearchEngine,
		            'visitors_keywords'		=> $Keywords
		        );
			    $this->Database->prepare("INSERT INTO tl_visitors_searchengines %s")->set($arrSet)->executeUncached();
			    // Delete old entries
			    $CleanTime = mktime(0, 0, 0, date("m")-3, date("d"), date("Y")); // Einträge >= 90 Tage werden gelöscht
			    $this->Database->prepare("DELETE FROM tl_visitors_searchengines WHERE tstamp<? AND vid=?")
		                       ->execute($CleanTime,$vid);
			} //keywords
		} //searchengine
	} //VisitorCheckSearchEngine
	
	/**
	 * Check for Referrer
	 *
	 * @param integer $vid	Visitors ID
	 */
	protected function VisitorCheckReferrer($vid)
	{
		if ($this->_VB === false) {
			if ($this->_PF === false) {
				$this->import('ModuleVisitorReferrer');
				$this->ModuleVisitorReferrer->checkReferrer();
				$ReferrerDNS = $this->ModuleVisitorReferrer->getReferrerDNS();
				$ReferrerFull= $this->ModuleVisitorReferrer->getReferrerFull();
				if ($ReferrerDNS != 'o' && $ReferrerDNS != 'w') { // not the own, not wrong
					// Insert
			        $arrSet = array
			        (
			            'vid'                   => $vid,
			            'tstamp'                => time(),
			            'visitors_referrer_dns' => $ReferrerDNS,
			            'visitors_referrer_full'=> $ReferrerFull
			        );
			        //Referrer setzen
			        $this->Database->prepare("INSERT INTO tl_visitors_referrer %s")->set($arrSet)->executeUncached();
				    // Delete old entries
				    $CleanTime = mktime(0, 0, 0, date("m")-4, date("d"), date("Y")); // Einträge >= 120 Tage werden gelöscht
				    $this->Database->prepare("DELETE FROM tl_visitors_referrer WHERE tstamp<? AND vid=?")
			                       ->execute($CleanTime,$vid);
				}
		    } //if PF
	    } //if VB
	} // VisitorCheckReferrer
	
} // class

// Version
require_once(TL_ROOT . '/system/modules/visitors/ModuleVisitorVersion.php');
/**
 * Instantiate controller
 */
$objVisitorsCount = new ModuleVisitorsCount();
$objVisitorsCount->run();

?>