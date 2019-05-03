<?php

namespace Faxity\Dice;

use Anax\Response\ResponseUtility;
use Anax\Di\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Game test class.
 */
class DiceControllerTest extends TestCase
{
    private $controller;
    private $app;


    /**
     * Setup for every test case
     * @return void.
     */
    public function setUp() : void
    {
        global $di;

        // Create dependency injector with the controller
        $di = new DIMagic();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $di->set("app", $di);

        $this->controller = new DiceController();
        $this->controller->setApp($di);
        $this->app = $di;
    }

    /**
     * Teardown for every test case
     * @return void.
     */
    public function tearDown() : void
    {
        global $di;

        $di = null;
        $this->controller = null;
        $this->app = null;
    }

    public function testIndexActionGet() : void
    {
        $res = $this->controller->indexActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testTurnActionGet() : void
    {
        $res = $this->controller->turnActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
    
    public function testEndActionGet() : void
    {
        $res = $this->controller->endActionGet();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    public function testIndexActionPost() : void
    {
        $res = $this->controller->indexActionPost();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    public function testTurnActionPostToss() : void
    {
        $this->app->request->setGlobals([
            "post" => [
                "action" => "toss",
            ]
        ]);

        $res = $this->controller->turnActionPost();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }


    public function testTurnActionPostEndTurn() : void
    {
        $this->app->request->setGlobals([
            "post" => [
                "action" => "end_turn",
            ]
        ]);

        $res = $this->controller->turnActionPost();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }

    public function testEndActionPost() : void
    {
        $res = $this->controller->endActionPost();

        $this->assertInstanceOf(ResponseUtility::class, $res);
    }
}
