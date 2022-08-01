<?php

class PlatformTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    public function testDefaultPlatform()
    {
        $this->tester->seeInDatabase('platforms', ['name' => 'Super Nintendo Entertainment System']);
    }
}