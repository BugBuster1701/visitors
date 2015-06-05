<?php
/**
 * Contao complete install with database.
 * Visitors complete install with Botdetection, cat id 1, counter id 1
 * cd TL_ROOT 
 * phpunit system/modules/visitors/tests/ModuleVisitorsTagTest.php
 * or
 * cd TL_ROOT/system/modules/visitors/tests/
 * phpunit ModuleVisitorsTagTest.php
 */

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');

$dir = __DIR__;

while ($dir != '.' && $dir != '/' && !is_file($dir . '/system/initialize.php'))
{
    $dir = dirname($dir);
}

if (!is_file($dir . '/system/initialize.php'))
{
    throw new \ErrorException('Could not find initialize.php!',2,1,basename(__FILE__),__LINE__);
}
require($dir . '/system/initialize.php');


require_once TL_ROOT .'/system/modules/visitors/classes/ModuleVisitorsTag.php';

require_once 'PHPUnit/Framework/TestCase.php';


/**
 * ModuleVisitorsTag test case.
 */
class ModuleVisitorsTagTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var ModuleVisitorsTag
     */
    private $ModuleVisitorsTag;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // for visitors::1::start
        $objPage = new stdClass();
        $objPage->dateFormat = 'Y.m.d';
        $objPage->id = 2; // Page "home/index" 
        $GLOBALS['objPage'] = $objPage;
        // for visitors::1::bestday::date
        $GLOBALS['TL_CONFIG']['dateFormat'] = 'Y.m.d';
        $this->ModuleVisitorsTag = new BugBuster\Visitors\ModuleVisitorsTag(/* parameters */);

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // Auto-generated ModuleVisitorsTagTest::tearDown()
        $this->ModuleVisitorsTag = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     * Parameter wegen dataProvider, sonst -> Missing argument 1
     */  
    public function __construct($name = NULL, array $data = array(), $dataName = '')
    {
        $GLOBALS['TL_CONFIG']['cacheMode'] = 'server';
        $GLOBALS['TL_CONFIG']['mod_visitors_bot_check'] = false;
        
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Basic Tests ModuleVisitorsTag->replaceInsertTagsVisitors()
     */
    public function testReplaceInsertTagsVisitorsBasics()
    {
        //Test: not the correct tag
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors('notforme::notforme');
        $this->assertFalse($return);
        
        //Test: no category id
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors('visitors');
        $this->assertFalse($return);
        
        //Test: no key
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors('visitors::1');
        $this->assertFalse($return);
        
        //Test: wrong category id
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors('visitors::1984::name');
        $this->assertFalse($return);
        
        //Test: wrong key
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors('visitors::1::wrong');
        $this->assertFalse($return);
        
    }
    
    /**
     * Tag2 Tests ModuleVisitorsTag->replaceInsertTagsVisitors()
     * 
     * @dataProvider providertag2
     */
    public function testReplaceInsertTagsVisitorsTag2($result, $tag)
    {

        //Test Tag2 = count
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors($tag);
        //Result must be equal
		$this->assertEquals($result,$return);
    }
    public function providertag2()
    {
        return array(//result,insert-tag
                array('Besucher'        , 'visitors::1::name'),
                array('1'               , 'visitors::1::online'),
                array('2015.06.01'      , 'visitors::1::start'),
                array('68'              , 'visitors::1::totalvisit'),
                array('442'             , 'visitors::1::totalhit'),
                array('2'               , 'visitors::1::todayvisit'),
                array('11'              , 'visitors::1::todayhit'),
                array('0'               , 'visitors::1::averagevisits'),
                array('<!-- counted -->', 'visitors::1::count')
        );
    }
    
    /**
     * Tag3 Tests ModuleVisitorsTag->replaceInsertTagsVisitors()
     *
     * @dataProvider providertag3
     */
    public function testReplaceInsertTagsVisitorsTag3($result, $tag)
    {
    
        //Test Tag2 = bestday, tag3 = date|visits|hits
        $return = $this->ModuleVisitorsTag->replaceInsertTagsVisitors($tag);
        //Result must be equal
        $this->assertEquals($result,$return);
    }
    public function providertag3()
    {
        return array(//result,insert-tag
            array(false             , 'visitors::1::bestday'),
            array('2014.01.02'      , 'visitors::1::bestday::date'),
            array('02.01.2014'      , 'visitors::1::bestday::date::d.m.Y'),
            array('3'               , 'visitors::1::bestday::visits'),
            array('9'               , 'visitors::1::bestday::hits') 
        );
    }
}

