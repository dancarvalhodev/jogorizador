<?php

class PlatformCest
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function testAddPlatform(AcceptanceTester $I)
    {
        for ($i = 1; $i <= 100; $i++) {
            $I->amOnPage('/');
            $I->see('Welcome to Jogorizator');
            $I->click('Add Platform');
            $I->fillField('name', $this->faker->word());
            $I->fillField('developer', $this->faker->word());
            $I->fillField('generation', $this->faker->word());
            $I->fillField('release_jp', $this->faker->date('Y-m-d'));
            $I->fillField('release_us', $this->faker->date('Y-m-d'));
            $I->fillField('release_br', $this->faker->date('Y-m-d'));
            $I->fillField('media_type', $this->faker->word());
            $I->click('Insert');
            $I->dontSee('Failed to insert Platform');
        }
    }
}
