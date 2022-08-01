<?php

class RomCest
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function testAddRom(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Welcome to Jogorizator');
        $I->click('Add Rom');
        $I->fillField('name', $this->faker->word());
        $I->selectOption('platforms', 'Super Nintendo Entertainment System');
        $I->fillField('developer', $this->faker->word());
        $I->fillField('publisher', $this->faker->word());
        $I->fillField('series', $this->faker->word());
        $I->fillField('release', $this->faker->date('Y-m-d'));
        $I->fillField('mode', $this->faker->word());
        $I->click('Insert');
        $I->expect('Rom Inserted successfully');
        $I->see('Rom Inserted successfully');
    }
}
