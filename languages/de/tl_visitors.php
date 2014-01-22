<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors (de).
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2014 
 * @author     Glen Langer 
 * @package    VisitorsLanguage 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_visitors']['visitors_name']        = array('Name', 'Bitte geben Sie einen Namen an f&uuml;r diesen Besucherz&auml;hler.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate']   = array('Startdatum', 'Hier kann ein Startdatum angegeben werden. Dieses Datum wird dann zur Information im Frontend angezeigt.<br>Es beeinflusst nicht den Beginn der Z&auml;hlung!');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_visit_start'] = array('Startwert Besucher', 'Die eingegebene Zahl wird zu den Z&auml;hlungen addiert.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_hit_start']   = array('Startwert Zugriffe'  , 'Die eingegebene Zahl wird zu den Z&auml;hlungen addiert.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_average']     = array('Besucher pro Tag', 'Bei Aktivierung erscheint im Frontend zus&auml;tzlich eine Zeile mit der Durchschnittsanzahl der Besucher pro Tag.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_block_time']  = array('Blockzeit', 'Zeit in Sekunden. Nach Zugriffspause dieser Zeit wird ein Zugriff als weiterer Besucher gez&auml;hlt.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_thousands_separator'] = array('Tausendertrennzeichen','Bei Aktivierung werden im Frontend Tausendertrennzeichen eingef&uuml;gt.');
$GLOBALS['TL_LANG']['tl_visitors']['published']            = array('Veröffentlicht', 'Der Besucherz&auml;hler wird erst auf Ihrer Webseite erscheinen, wenn dieser ver&ouml;ffentlicht ist.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_visitors']['not_defined']   = 'Nicht definiert';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors']['title_legend']   = 'Name und Startdatum';
$GLOBALS['TL_LANG']['tl_visitors']['start_legend']   = 'Startwerte für Z&auml;hler';
$GLOBALS['TL_LANG']['tl_visitors']['average_legend'] = 'Durchschnitt und Blockzeit';
$GLOBALS['TL_LANG']['tl_visitors']['publish_legend'] = 'Ver&ouml;ffentlichung';
$GLOBALS['TL_LANG']['tl_visitors']['design_legend']  = 'Darstellung';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors']['new']        = array('Neuer Besucherz&auml;hler', 'Neuen Besucherz&auml;hler erstellen');
$GLOBALS['TL_LANG']['tl_visitors']['edit']       = array('Besucherz&auml;hler bearbeiten', 'Besucherz&auml;hler ID %s bearbeiten');
$GLOBALS['TL_LANG']['tl_visitors']['copy']       = array('Besucherz&auml;hler duplizieren', 'Besucherz&auml;hler ID %s duplizieren');
$GLOBALS['TL_LANG']['tl_visitors']['delete']     = array('Besucherz&auml;hler l&ouml;schen', 'Besucherz&auml;hler ID %s l&ouml;schen');
$GLOBALS['TL_LANG']['tl_visitors']['show']       = array('Details', 'Details der Besucherz&auml;hler ID %s anzeigen');
$GLOBALS['TL_LANG']['tl_visitors']['editheader'] = array('Kategorie bearbeiten', 'Diese Kategorie bearbeiten');
$GLOBALS['TL_LANG']['tl_visitors']['toggle']     = array('Besucherz&auml;hler ein- oder ausschalten', 'Besucherz&auml;hler ID %s ein- oder ausschalten');

/**
 * Errorlog
 */
$GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'] = 'Fehlerhafte oder falsche Kategorie ID (Parameter 2)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_key']   = 'Fehlerhafter oder falscher Tagname (Parameter 3)';
$GLOBALS['TL_LANG']['tl_visitors']['no_key']      = 'Kein Tagname angegeben (Parameter 3)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_count_katid'] = 'Aufruf ohne Parameter';
$GLOBALS['TL_LANG']['tl_visitors']['no_param4']   = 'Aufruf ohne Parameter 4';
