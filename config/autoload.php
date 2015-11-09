<?php

/**
 * Contao Open Source CMS, Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Visitors
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'BugBuster',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'BugBuster\Visitors\ModuleVisitorStat'              => 'system/modules/visitors/modules/ModuleVisitorStat.php',
	'BugBuster\Visitors\ModuleVisitors'                 => 'system/modules/visitors/modules/ModuleVisitors.php',

	// Public
	'BugBuster\Visitors\ModuleVisitorsCount'            => 'system/modules/visitors/public/ModuleVisitorsCount.php',
	'BugBuster\Visitors\ModuleVisitorsScreenCount'      => 'system/modules/visitors/public/ModuleVisitorsScreenCount.php',
	'BugBuster\Visitors\ModuleVisitorReferrerDetails'   => 'system/modules/visitors/public/ModuleVisitorReferrerDetails.php',

	// Classes
	'BugBuster\Visitors\ModuleVisitorBrowser3'          => 'system/modules/visitors/classes/ModuleVisitorBrowser3.php',
	'BugBuster\Visitors\ModuleVisitorStatScreenCounter' => 'system/modules/visitors/classes/ModuleVisitorStatScreenCounter.php',
	'BugBuster\Visitors\DcaModuleVisitors'              => 'system/modules/visitors/classes/DcaModuleVisitors.php',
	'BugBuster\Visitors\DcaVisitors'                    => 'system/modules/visitors/classes/DcaVisitors.php',
	'BugBuster\Visitors\DcaVisitorsCategory'            => 'system/modules/visitors/classes/DcaVisitorsCategory.php',
	'BugBuster\Visitors\ModuleVisitorStatPageCounter'   => 'system/modules/visitors/classes/ModuleVisitorStatPageCounter.php',
	'BugBuster\Visitors\ModuleVisitorSearchEngine'      => 'system/modules/visitors/classes/ModuleVisitorSearchEngine.php',
	'BugBuster\Visitors\ModuleVisitorsTag'              => 'system/modules/visitors/classes/ModuleVisitorsTag.php',
	'BugBuster\Visitors\ModuleVisitorLog'               => 'system/modules/visitors/classes/ModuleVisitorLog.php',
	'BugBuster\Visitors\ModuleVisitorReferrer'          => 'system/modules/visitors/classes/ModuleVisitorReferrer.php',
	'BugBuster\Visitors\ModuleVisitorCharts'            => 'system/modules/visitors/classes/ModuleVisitorCharts.php',
	'BugBuster\Visitors\ModuleVisitorChecks'            => 'system/modules/visitors/classes/ModuleVisitorChecks.php',
	'BugBuster\Visitors\Stat\Export\VisitorsStatExport' => 'system/modules/visitors/classes/VisitorsStatExport.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_visitors_fe_invisible'                            => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_pagevisithittop'         => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_pagevisithitdays'        => 'system/modules/visitors/templates',
	'mod_visitors_fe_all'                                  => 'system/modules/visitors/templates',
	'mod_visitors_fe_hits'                                 => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_screentopresolution'     => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_screentopresolutiondays' => 'system/modules/visitors/templates',
	'mod_visitors_error'                                   => 'system/modules/visitors/templates',
	'mod_visitors_fe_visits'                               => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_pagevisithittoday'       => 'system/modules/visitors/templates',
	'mod_visitors_be_stat_partial_pagevisithityesterday'   => 'system/modules/visitors/templates',
	'mod_visitors_be_stat'                                 => 'system/modules/visitors/templates',
));
