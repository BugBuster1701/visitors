<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2011 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Checks - Frontend
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2012
 * @author     Glen Langer 
 * @package    GLVisitors 
 * @license    LGPL 
 * @filesource
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Visitors;

/**
 * Class ModuleVisitorChecks 
 *
 * @copyright  Glen Langer 2012
 * @author     Glen Langer 
 * @package    GLVisitors
 * @license    LGPL 
 */
class ModuleVisitorChecks extends \Frontend
{
	/**
	 * Current version of the class.
	 */
	const VERSION           = '3.0';
	
	/**
	 * Spider Bot Check
	 */
	public function CheckBot()
	{
		if (!in_array('botdetection', $this->Config->getActiveModules()))
		{
			//botdetection Modul fehlt, Abbruch
			$this->log('BotDetection extension required!', 'ModuleVisitorChecks CheckBot', TL_ERROR);
			return false;
		}
		//$this->import('ModuleBotDetection');
		$this->import('BotDetection\ModuleBotDetection','ModuleBotDetection'); //Workaround for $this->ModuleBotDetection->...
	    if ($this->ModuleBotDetection->BD_CheckBotAgent() || $this->ModuleBotDetection->BD_CheckBotIP()) 
	    {
	    	//log_message('CheckBot True','debug.log');
	    	return true;
	    }
	    //log_message('CheckBot False','debug.log');
	    return false;
	} //CheckBot
	
	/**
	 * HTTP_USER_AGENT Special Check
	 */
	public function CheckUserAgent($visitors_category_id)
	{
   	    if (\Environment::get('httpUserAgent')) 
   	    { 
	        $UserAgent = trim(\Environment::get('httpUserAgent')); 
	    } 
	    else 
	    { 
	        return false; // Ohne Absender keine Suche
	    }
	    $arrUserAgents = array();
	    $objUserAgents = $this->Database->prepare("SELECT `visitors_useragent` FROM `tl_module` WHERE `type` = ? AND `visitors_categories` = ?")
	                                    ->execute('visitors',$visitors_category_id);
		if ($objUserAgents->numRows) 
		{
			while ($objUserAgents->next()) 
			{
				$arrUserAgents = array_merge($arrUserAgents,explode(",", $objUserAgents->visitors_useragent));
			}
		}
	    if (strlen(trim($arrUserAgents[0])) == 0) 
	    {
	    	return false; // keine Angaben im Modul
	    }
        // Suche
        $CheckUserAgent=str_replace($arrUserAgents, '#', $UserAgent);
        if ($UserAgent != $CheckUserAgent) 
        { 	// es wurde ersetzt also was gefunden
        	//log_message('CheckBotUserAgent True','debug.log');
            return true;
        }
        //log_message('CheckBotUserAgent False','debug.log');
        return false; 
	} //CheckUserAgent
	
	/**
	 * BE Login Check
	 * basiert auf Frontend.getLoginStatus
	 */
	public function CheckBE()
	{
		$strCookie = 'BE_USER_AUTH';
		$hash = sha1(session_id() . (!$GLOBALS['TL_CONFIG']['disableIpCheck'] ? \Environment::get('ip') : '') . $strCookie);
		if (\Input::cookie($strCookie) == $hash)
		{
			/*
			$objSession = $this->Database->prepare("SELECT * FROM tl_session WHERE hash=? AND name=?")
										 ->limit(1)
										 ->execute($hash, $strCookie);
			*/
			// Try to find the session
			$objSession = \SessionModel::findByHashAndName($hash, $strCookie);
			//if ($objSession->numRows && $objSession->sessionID == session_id() && $objSession->ip == $this->Environment->ip && ($objSession->tstamp + $GLOBALS['TL_CONFIG']['sessionTimeout']) > time())
			// Validate the session ID and timeout
			if ($objSession !== null && $objSession->sessionID == session_id() && ($GLOBALS['TL_CONFIG']['disableIpCheck'] || $objSession->ip == \Environment::get('ip')) && ($objSession->tstamp + $GLOBALS['TL_CONFIG']['sessionTimeout']) > time())
			{
				//log_message('CheckBotBELogin True','debug.log');
				return true;
			}
		}
		//log_message('CheckBotBELogin False','debug.log');
		return false;
	} //CheckBE
	
}

