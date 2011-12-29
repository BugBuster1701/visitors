<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors_category (de).
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2010 
 * @author     Glen Langer 
 * @package    VisitorsLanguage 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['title']              = array('Kategorie', 'Bitte geben Sie den Namen der Kategorie ein.');
//$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_template']  = array('Besucher Vorlage', 'Bitte w&auml;hlen Sie eine Besucher-Vorlage. Sie k&ouml;nnen eigene Vorlagen im Ordner <em>templates</em> speichern. Vorlagen m&uuml;ssen mit <em>mod_visitors_fe_</em> beginnen und die Dateiendung <em>.tpl</em> haben.'); 
$GLOBALS['TL_LANG']['tl_visitors_category']['tstamp']             = array('&Auml;nderungsdatum', 'Datum und Uhrzeit der letzten &Auml;nderung');
$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_cache_mode']= array('Zählweise bei eingeschaltetem Seiten Cache','');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['title_legend']     = 'Kategorie und Besuchervorlage'; 
$GLOBALS['TL_LANG']['tl_visitors_category']['cache_legend']     = 'Zählweise'; 

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['deleteConfirm'] = 'Wenn Sie eine Kategorie l&ouml;schen werden auch alle darin enthaltenen Besucher Definitionen gel&ouml;scht. Wollen Sie die Kategorie ID %s wirklich l&ouml;schen?';
$GLOBALS['TL_LANG']['tl_visitors_category']['1'] = 'Last Zählung, serverseitig durch Contao';
$GLOBALS['TL_LANG']['tl_visitors_category']['2'] = 'Lese Zählung, clientseitig durch Browser (nur im Contao cacheModus: Server- und Browsercache / Nur Browsercache)';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['new']    = array('Neue Kategorie', 'Eine neue Kategorie anlegen');
$GLOBALS['TL_LANG']['tl_visitors_category']['edit']   = array('Kategorie bearbeiten', 'Kategorie ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_visitors_category']['copy']   = array('Kategorie duplizieren', 'Kategorie ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_visitors_category']['delete'] = array('Kategorie l&ouml;schen', 'Kategorie ID %s l&ouml;schen');
$GLOBALS['TL_LANG']['tl_visitors_category']['show']   = array('Kategoriedetails', 'Details der Kategorie ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_visitors_category']['stat']   = array('Kategoriestatistik', 'Besucherstatistik f&uuml;r die Kategorie ID %s anzeigen');

?>