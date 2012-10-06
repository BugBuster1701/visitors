<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package Visitors
 * @link    http://contao.org
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
	// Classes
	'BugBuster\Visitors\ModuleVisitorBrowser3'        => 'system/modules/visitors/classes/ModuleVisitorBrowser3.php',
	'BugBuster\Visitors\ModuleVisitorCharts'          => 'system/modules/visitors/classes/ModuleVisitorCharts.php',
	'BugBuster\Visitors\ModuleVisitorChecks'          => 'system/modules/visitors/classes/ModuleVisitorChecks.php',
	'BugBuster\Visitors\ModuleVisitorReferrer'        => 'system/modules/visitors/classes/ModuleVisitorReferrer.php',
	'BugBuster\Visitors\ModuleVisitorSearchEngine'    => 'system/modules/visitors/classes/ModuleVisitorSearchEngine.php',
	'BugBuster\Visitors\ModuleVisitorsTag'            => 'system/modules/visitors/classes/ModuleVisitorsTag.php',

	// Export
	'BugBuster\Visitors\VisitorsStatExport'           => 'system/modules/visitors/export/VisitorsStatExport.php',
	'BugBuster\Visitors\VisitorsStatExportcsv'        => 'system/modules/visitors/export/VisitorsStatExportcsv.php',
	'BugBuster\Visitors\VisitorsStatExportexcel'      => 'system/modules/visitors/export/VisitorsStatExportexcel.php',
	'BugBuster\Visitors\VisitorsStatExportexcel95'    => 'system/modules/visitors/export/VisitorsStatExportexcel95.php',

	// Modules
	'BugBuster\Visitors\ModuleVisitors'               => 'system/modules/visitors/modules/ModuleVisitors.php',
	'BugBuster\Visitors\ModuleVisitorStat'            => 'system/modules/visitors/modules/ModuleVisitorStat.php',

	// Public
	'BugBuster\Visitors\ModuleVisitorReferrerDetails' => 'system/modules/visitors/public/ModuleVisitorReferrerDetails.php',
	'BugBuster\Visitors\ModuleVisitorsCount'          => 'system/modules/visitors/public/ModuleVisitorsCount.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_visitors_be_stat'      => 'system/modules/visitors/templates',
	'mod_visitors_error'        => 'system/modules/visitors/templates',
	'mod_visitors_fe_all'       => 'system/modules/visitors/templates',
	'mod_visitors_fe_hits'      => 'system/modules/visitors/templates',
	'mod_visitors_fe_invisible' => 'system/modules/visitors/templates',
	'mod_visitors_fe_visits'    => 'system/modules/visitors/templates',
));
