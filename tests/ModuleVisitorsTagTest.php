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
        
        // TODO Auto-generated ModuleVisitorsTagTest::setUp()
        
        $this->ModuleVisitorsTag = new BugBuster\Visitors\ModuleVisitorsTag(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated ModuleVisitorsTagTest::tearDown()
        $this->ModuleVisitorsTag = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        // TODO Auto-generated constructor
        $GLOBALS['TL_CONFIG']['cacheMode'] = 'server';
        
        $GLOBALS['TL_CONFIG']['mod_visitors_bot_check'] = false;
        
    }

    /**
     * Tests ModuleVisitorsTag->replaceInsertTagsVisitors()
     */
    public function testReplaceInsertTagsVisitors()
    {
        // TODO Auto-generated ModuleVisitorsTagTest->testReplaceInsertTagsVisitors()
        
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
        
        $this->markTestIncomplete("replaceInsertTagsVisitors test not complete implemented");
        
    }
}

