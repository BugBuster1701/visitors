<?php

/**
 * Contao Open Source CMS, Copyright (C) 2005-2014 Leo Feyer
 *
 * Modul Visitors Stat Page Counter
 *
 * @copyright  Glen Langer 2009..2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 * @license    LGPL
 * @filesource
 * @see	       https://github.com/BugBuster1701/visitors
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\Visitors;

/**
 * Class ModuleVisitorStatPageCounter
 *
 * @copyright  Glen Langer 2014 <http://www.contao.glen-langer.de>
 * @author     Glen Langer (BugBuster)
 * @package    GLVisitors
 */
class ModuleVisitorStatPageCounter extends \BackendModule
{
    
    /**
     * Current object instance
     * @var object
     */
    protected static $instance = null;
    
    protected $today;
    protected $yesterday;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->today     = date('Y-m-d');
        $this->yesterday = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y")));
    }
    
    
    protected function compile()
    {
    
    }
    
    /**
     * Return the current object instance (Singleton)
     * @return ModuleVisitorStatPageCounter
     */
    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new ModuleVisitorStatPageCounter();
        }
    
        return self::$instance;
    }

    //////////////////////////////////////////////////////////////
    
    public function generatePageVisitHitTop($VisitorsID,$days=20)
    {
        $arrPageStatCount = false;
        
        $this->TemplatePartial = new \BackendTemplate('mod_visitors_be_stat_partial_pagevisithittop');
        
        $objPageStatCount = \Database::getInstance()
                        ->prepare("SELECT 
                                        visitors_page_id,
                                        visitors_page_lang,
                                        SUM(visitors_page_visit) AS visitors_page_visits,
                                        SUM(visitors_page_hit)   AS visitors_page_hits
                                    FROM
                                        tl_visitors_pages
                                    WHERE
                                        vid = ?
                                    GROUP BY 
                                        visitors_page_id, 
                                        visitors_page_lang
                                    ORDER BY 
                                        visitors_page_visits DESC,
                                        visitors_page_hits DESC,
                                        visitors_page_id,
                                        visitors_page_lang
                                ")
                        ->limit($days)
                        ->execute($VisitorsID);
        
        while ($objPageStatCount->next())
        {
            $objPage = \PageModel::findWithDetails($objPageStatCount->visitors_page_id);
            $arrPageStatCount[] = array
            (
                'alias'         => $objPage->alias,
                'lang'          => $objPageStatCount->visitors_page_lang,
                'visits'        => $objPageStatCount->visitors_page_visits,
                'hits'          => $objPageStatCount->visitors_page_hits
            );
        }
        
        $this->TemplatePartial->PageVisitHitTop = $arrPageStatCount;        
        return $this->TemplatePartial->parse();
    }
    
    public function generatePageVisitHitToday($VisitorsID, $limit=5)
    {
        $arrPageStatCount = false;
        
        $this->TemplatePartial = new \BackendTemplate('mod_visitors_be_stat_partial_pagevisithittoday');
        
        $objPageStatCount = \Database::getInstance()
                        ->prepare("SELECT
                                        visitors_page_id,
                                        visitors_page_lang,
                                        SUM(visitors_page_visit) AS visitors_page_visits,
                                        SUM(visitors_page_hit)   AS visitors_page_hits
                                    FROM
                                        tl_visitors_pages
                                    WHERE
                                        vid = ?
                                    AND
                                        visitors_page_date = ?
                                    GROUP BY
                                        visitors_page_id,
                                        visitors_page_lang
                                    ORDER BY
                                        visitors_page_visits DESC,
                                        visitors_page_hits DESC,
                                        visitors_page_id,
                                        visitors_page_lang
                                ")
                        ->limit($limit)
                        ->execute($VisitorsID, $this->today);
        
        while ($objPageStatCount->next())
        {
            $objPage = \PageModel::findWithDetails($objPageStatCount->visitors_page_id);
            $arrPageStatCount[] = array
            (
                'alias'         => $objPage->alias,
                'lang'          => $objPageStatCount->visitors_page_lang,
                'visits'        => $objPageStatCount->visitors_page_visits,
                'hits'          => $objPageStatCount->visitors_page_hits
            );
        }
        
        $this->TemplatePartial->PageVisitHitToday = $arrPageStatCount;
        
        return $this->TemplatePartial->parse();
    }
    
    public function generatePageVisitHitYesterday($VisitorsID, $limit=5)
    {
        $arrPageStatCount = false;
        
        $this->TemplatePartial = new \BackendTemplate('mod_visitors_be_stat_partial_pagevisithityesterday');
        
        $objPageStatCount = \Database::getInstance()
                        ->prepare("SELECT
                                        visitors_page_id,
                                        visitors_page_lang,
                                        SUM(visitors_page_visit) AS visitors_page_visits,
                                        SUM(visitors_page_hit)   AS visitors_page_hits
                                    FROM
                                        tl_visitors_pages
                                    WHERE
                                        vid = ?
                                    AND
                                        visitors_page_date = ?
                                    GROUP BY
                                        visitors_page_id,
                                        visitors_page_lang
                                    ORDER BY
                                        visitors_page_visits DESC,
                                        visitors_page_hits DESC,
                                        visitors_page_id,
                                        visitors_page_lang
                                ")
                        ->limit($limit)
                        ->execute($VisitorsID, $this->yesterday);
        
        while ($objPageStatCount->next())
        {
            $objPage = \PageModel::findWithDetails($objPageStatCount->visitors_page_id);
            $arrPageStatCount[] = array
            (
                'alias'         => $objPage->alias,
                'lang'          => $objPageStatCount->visitors_page_lang,
                'visits'        => $objPageStatCount->visitors_page_visits,
                'hits'          => $objPageStatCount->visitors_page_hits
            );
        }
        
        $this->TemplatePartial->PageVisitHitYesterday = $arrPageStatCount;
        
        return $this->TemplatePartial->parse();
    }
    
    public function generatePageVisitHitDays($VisitorsID, $limit=20, $days=7)
    {
        $arrPageStatCount = false;
        $week = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-$days, date("Y")));
        
        $this->TemplatePartial = new \BackendTemplate('mod_visitors_be_stat_partial_pagevisithitdays');
        
        $objPageStatCount = \Database::getInstance()
                        ->prepare("SELECT
                                        visitors_page_id,
                                        visitors_page_lang,
                                        SUM(visitors_page_visit) AS visitors_page_visits,
                                        SUM(visitors_page_hit)   AS visitors_page_hits
                                    FROM
                                        tl_visitors_pages
                                    WHERE
                                        vid = ?
                                    AND
                                        visitors_page_date >= ?
                                    GROUP BY
                                        visitors_page_id,
                                        visitors_page_lang
                                    ORDER BY
                                        visitors_page_visits DESC,
                                        visitors_page_hits DESC,
                                        visitors_page_id,
                                        visitors_page_lang
                                ")
                        ->limit($limit)
                        ->execute($VisitorsID, $week);
        
        while ($objPageStatCount->next())
        {
            $objPage = \PageModel::findWithDetails($objPageStatCount->visitors_page_id);
            $arrPageStatCount[] = array
            (
                'alias'         => $objPage->alias,
                'lang'          => $objPageStatCount->visitors_page_lang,
                'visits'        => $objPageStatCount->visitors_page_visits,
                'hits'          => $objPageStatCount->visitors_page_hits
            );
        }

        $this->TemplatePartial->PageVisitHitDays = $arrPageStatCount;
        
        return $this->TemplatePartial->parse();
    }
    
    
    
    
    
    
    
    
    
    
    
}
