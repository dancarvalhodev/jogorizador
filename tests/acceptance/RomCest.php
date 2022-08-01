<?php

class RomCest
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    /**
     * @depends PlatformCest:testAddPlatform
     */
    public function testAddRom(AcceptanceTester $I)
    {
        for ($i = 1; $i <= 100; $i++) {
            $I->amOnPage('/');
            $I->see('Welcome to Jogorizator');
            $I->click('Add Rom');
            $I->fillField('name', $this->faker->word());
            $I->selectOption('platforms', $this->faker->numberBetween(1, 100));
            $I->fillField('developer', $this->faker->word());
            $I->fillField('publisher', $this->faker->word());
            $I->fillField('series', $this->faker->word());
            $I->fillField('release', $this->faker->date('Y-m-d'));
            $I->fillField('mode', $this->faker->word());
            $I->click('Insert');
            $I->dontSee('Failed to insert Rom');
        }
    }
}
