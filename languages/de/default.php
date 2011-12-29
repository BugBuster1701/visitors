<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for default (de).
 *
 * PHP version 5
 * @copyright  Glen Langer 2009..2010 
 * @author     Glen Langer 
 * @package    VisitorsLanguage
 * @license    LGPL 
 * @filesource
 */


/**
 * Miscellaneous
 */
//$GLOBALS['TL_LANG']['MSC'][''] = '';

/**
 * Frontend
 */
$GLOBALS['TL_LANG']['visitors']['VisitorsNameLegend']        = '';
$GLOBALS['TL_LANG']['visitors']['VisitorsOnlineCountLegend'] = 'Online:';
$GLOBALS['TL_LANG']['visitors']['VisitorsStartDateLegend']   = 'Zählung seit:';
$GLOBALS['TL_LANG']['visitors']['TotalVisitCountLegend']     = 'Besucher gesamt:';
$GLOBALS['TL_LANG']['visitors']['TotalHitCountLegend']       = 'Zugriffe gesamt:';
$GLOBALS['TL_LANG']['visitors']['TodayVisitCountLegend']     = 'Besucher heute:';
$GLOBALS['TL_LANG']['visitors']['TodayHitCountLegend']       = 'Zugriffe heute:';
$GLOBALS['TL_LANG']['visitors']['AverageVisitsLegend']       = 'Besucher pro Tag:';

/**
 * Backend Statistik
 */
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_yes']   = 'ja';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['pub_no']    = 'nein';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['name']      = 'Name';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['active']    = 'Aktiv';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['date']      = 'Datum';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['startdate'] = 'Z&auml;hlung seit';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['total']     = 'Gesamtzahl';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit']     = 'Besucher';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['hit']       = 'Zugriffe';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['modname']   = 'Visitors Modul';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['footer']    = '';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['select']    = 'Bitte ausw&auml;hlen';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['kat']       = 'Kategorie';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export']    = 'Export';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export_button_title'] = 'Der Export erfolgt in einem neuen Fenster.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['export_headline']     = 'Kategorie,ID,Name,Ver&ouml;ffentlicht,Datum,Besucher,Zugriffe';

$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['not_defined']   = 'Nicht definiert';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['no_data']       = 'Keine Daten vorhanden f&uuml;r diese Kategorie.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['no_stat_data']  = 'Keine Statistik Daten vorhanden f&uuml;r diesen Z&auml;hler.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['period']        = 'Zeitraum';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['today']         = 'Heute';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['yesterday']     = 'Gestern';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['current_week']  = 'aktuelle Woche';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['last_week']     = 'letzte Woche';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['current_month'] = 'aktueller Monat';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['last_month']    = 'letzter Monat';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['reset']         = 'R&uuml;cksetzung';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zero']          = 'Z&auml;hler und Statistiken auf 0 setzen f&uuml;r diesen Z&auml;hler.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zero_confirm']  = 'Z&auml;hler und Statistik der Besucher und Zugriffe wirklich auf 0 setzen f&uuml;r diesen Z&auml;hler?';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zerobrowser']   = 'Browserstatistik l&ouml;schen f&uuml;r diesen Z&auml;hler.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zerobrowser_confirm'] = 'Browserstatistik wirklich l&ouml;schen f&uuml;r diesen Z&auml;hler?';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_visits'] = 'Besucher pro Tag:';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_hits']   = 'Zugriffe pro Tag:';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_legend'] = 'Durchschnittswerte';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_tipp'] = '(30) / (60) = &Oslash; Werte der letzten 30 / 60 Tage';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['parameter']      = 'Vorgaben';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['initial_values'] = 'Startwerte';
$GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['most_visitors']   = 'Tag mit den meisten Besuchern';
$GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['fewest_visitors'] = 'Tag mit den wenigsten Besuchern';
$GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['visitors_this_day'] = 'Besucher an diesem Tag';
$GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['hits_this_day']     = 'Zugriffe an diesem Tag';
$GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['currently online']  = 'Derzeit online';

$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_version'] = 'Versionen';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_lang']    = 'Sprachen';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_os']      = 'Betriebssysteme';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_top10']     = 'Browser TOP 10';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_top20']     = 'Browser TOP 20';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_definition'] = 'Browser Definitionen';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_unknown']    = 'Unerkannte';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_known']      = 'Erkannte';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_osdif']      = 'unterschiedliche';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_no_data']  = 'Keine Daten vorhanden.';

$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['chart_red']   = 'rot';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['chart_green'] = 'gr&uuml;n';

$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchenginekeywords_top'] = 'Suchmaschinen-Schlüsselwörter TOP 20';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengines_top']        = 'Suchmaschinen TOP 20';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine_no_data'] = 'Keine Daten vorhanden.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine_data']    = 'Werte aus den Daten der letzten 60 Tage.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchenginekeywords'] = 'Suchbegriffe';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine']         = 'Suchmaschine';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['over']   = 'über';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['number'] = 'Anzahl';

$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_top']    = 'Besucherherkunft TOP 30';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_dns']    = 'Domain';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_data']   = 'Werte aus den Daten der letzten 120 Tage.';
$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_direct'] = 'Direkter Zugriff';

?>