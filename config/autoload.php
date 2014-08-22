<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
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
	// Export
	'BugBuster\Visitors\VisitorsStatExportexcel'        => 'system/modules/visitors/export/VisitorsStatExportexcel.php',
	'BugBuster\Visitors\VisitorsStatExport'             => 'system/modules/visitors/export/VisitorsStatExport.php',
	'BugBuster\Visitors\VisitorsStatExportexcel95'      => 'system/modules/visitors/export/VisitorsStatExportexcel95.php',
	'BugBuster\Visitors\VisitorsStatExportcsv'          => 'system/modules/visitors/export/VisitorsStatExportcsv.php',

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
	'BugBuster\Visitors\DCA_module_visitors'            => 'system/modules/visitors/classes/DCA_module_visitors.php',
	'BugBuster\Visitors\DCA_visitors'                   => 'system/modules/visitors/classes/DCA_visitors.php',
	'BugBuster\Visitors\DCA_visitors_category'          => 'system/modules/visitors/classes/DCA_visitors_category.php',
	'BugBuster\Visitors\ModuleVisitorStatPageCounter'   => 'system/modules/visitors/classes/ModuleVisitorStatPageCounter.php',
	'BugBuster\Visitors\ModuleVisitorSearchEngine'      => 'system/modules/visitors/classes/ModuleVisitorSearchEngine.php',
	'BugBuster\Visitors\ModuleVisitorsTag'              => 'system/modules/visitors/classes/ModuleVisitorsTag.php',
	'BugBuster\Visitors\ModuleVisitorLog'               => 'system/modules/visitors/classes/ModuleVisitorLog.php',
	'BugBuster\Visitors\ModuleVisitorReferrer'          => 'system/modules/visitors/classes/ModuleVisitorReferrer.php',
	'BugBuster\Visitors\ModuleVisitorCharts'            => 'system/modules/visitors/classes/ModuleVisitorCharts.php',
	'BugBuster\Visitors\ModuleVisitorChecks'            => 'system/modules/visitors/classes/ModuleVisitorChecks.php',
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
