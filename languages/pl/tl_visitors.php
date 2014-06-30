<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 * 
 * Modul Visitors Sprachdateien
 * 
 * Language file for table tl_visitors (en).
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
$GLOBALS['TL_LANG']['tl_visitors']['visitors_name']      = array('Nazwa', 'Wprowadź nazwę tego licznika.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_startdate'] = array('Data rozpoczecia', 'Tutaj możesz określić datę rozpoczęcia. Ta data będzie wyświetlana w frontendzie.<br>Nie wpływa na rozpoczęcie liczenia!');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_visit_start'] = array('Początkowa ilość wizyt', 'Wprowadzona wartość zostanie dodana do licznika.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_hit_start'] = array('Początkowa ilość odsłon', 'Wprowadzona wartość zostanie dodana do licznika.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_average']   = array('Wizyt dziennie', 'Po aktywacji w frontendzie będzie wyświetlana średnia dzienna liczba wizyt.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_block_time']   = array('Czas bloku', 'Po przerwaniu żadania po tym czasie osoba liczona jest jako dodatkowy odwiedzający.');
$GLOBALS['TL_LANG']['tl_visitors']['visitors_thousands_separator'] = array('Separator tysięcy','Po aktywacji separator tysięcy będzie wyświetlany w frontendzie.');
$GLOBALS['TL_LANG']['tl_visitors']['published']          = array('Opublikowany', 'Licznik nie będzie widoczny na stronie, dopóki nie zostanie opublikowany.');

/**
 * Reference
 */
//$GLOBALS['TL_LANG']['tl_visitors'][''] = '';
$GLOBALS['TL_LANG']['tl_visitors']['not_defined']   = 'Nie zdefiniowano';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_visitors']['title_legend']   = 'Nazwa i data rozpoczęcia';
$GLOBALS['TL_LANG']['tl_visitors']['start_legend']   = 'Opcjonalna wartość początkowa';
$GLOBALS['TL_LANG']['tl_visitors']['average_legend'] = 'Średnio i czas blokady';
$GLOBALS['TL_LANG']['tl_visitors']['publish_legend'] = 'Ustawienia publikacji';
$GLOBALS['TL_LANG']['tl_visitors']['design_legend']  = 'Projekt';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_visitors']['new']        = array('Nowy licznik', 'Stwórz nowy licznik');
$GLOBALS['TL_LANG']['tl_visitors']['edit']       = array('Edytuj licznik', 'Edytuj licznik ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['copy']       = array('Duplikuj licznik', 'Duplikuj licznik ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['delete']     = array('Usuń licznik', 'Usuń licznik ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['show']       = array('Szczegóły', 'Pokaż szczegóły licznika ID %s');
$GLOBALS['TL_LANG']['tl_visitors']['editheader'] = array('Edytuj kategorię', 'Edytuj tą kategorię');
$GLOBALS['TL_LANG']['tl_visitors']['toggle']     = array('Przełącz widoczność', 'Przełącz widoczność licznika ID %s');

/**
 * Errorlog
 */
$GLOBALS['TL_LANG']['tl_visitors']['wrong_katid'] = 'Wadliwe lub błędne ID kategorii (parametr 2)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_key']   = 'Wadliwy lub błędny tag (parametr 3)';
$GLOBALS['TL_LANG']['tl_visitors']['no_key']      = 'Nie określono tagu (parametr 3)';
$GLOBALS['TL_LANG']['tl_visitors']['wrong_count_katid'] = 'Wywołanie bez parametru';
$GLOBALS['TL_LANG']['tl_visitors']['no_param4']   = 'Wywołanie bez parametru 4';

?>