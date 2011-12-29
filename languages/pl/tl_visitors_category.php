<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors_category (en).
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
$GLOBALS['TL_LANG']['tl_visitors_category']['title']              = array('Tytuł', 'Wprowadź tytuł kategorii.');
//$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_template']  = array('Counter Template', 'Please choose the Counter-Template. Counter template files start with <em>mod_visitors_fe_</em>.'); 
$GLOBALS['TL_LANG']['tl_visitors_category']['tstamp']             = array('Data aktualizacji', 'Data i czas ostatniej aktualizacji');
$GLOBALS['TL_LANG']['tl_visitors_category']['visitors_cache_mode']= array('Tryb liczenia', 'Metoda liczenia gdy strony są buforowane.');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['title_legend']     = 'Tytuł i szablon licznika'; 
$GLOBALS['TL_LANG']['tl_visitors_category']['cache_legend']     = 'Tryb liczenia'; 

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['deleteConfirm'] = 'Usunięcie kategorii spowoduje usunięcie wszystkich przynależnych liczników. Czy na pewno chcesz usunąć kategorię ID %s?';
$GLOBALS['TL_LANG']['tl_visitors_category']['1'] = 'Liczenie obciążenia, po stronie Contao';
$GLOBALS['TL_LANG']['tl_visitors_category']['2'] = 'Liczenie czytelnika, po stronie przeglądarki (tylko z włączonym cacheMode: cache serwera i przeglądarki / tylko cache przeglądarki )';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors_category']['new']    = array('Nowa kategoria', 'Stwórz nową kategorię');
$GLOBALS['TL_LANG']['tl_visitors_category']['edit']   = array('Edytuj kategorię', 'Edytuj kategorię ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['copy']   = array('Kopiuj kategorię', 'Kopiuj kategorię ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['delete'] = array('Usuń kategorię', 'Usuń kategorię ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['show']   = array('Szczegóły kategorii', 'Pokaż szczegóły kategorii ID %s');
$GLOBALS['TL_LANG']['tl_visitors_category']['stat']   = array('Statystyki kategorii', 'Pokaż statystyki licznika dla kategorii ID %s');

?>