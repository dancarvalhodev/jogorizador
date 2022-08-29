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
        for ($i = 1; $i <= 20; $i++) {
            $I->amOnPage('/login');
            $I->see('Jogorizador - Login');
            $I->fillField('username', 'admin');
            $I->fillField('password', 'admin');
            $I->click('Sign in');
            $I->amOnPage('/');
            $I->see('Welcome to Jogorizator');
            $I->click('Add Platform');
            $I->fillField('name', "Platform {$i}");
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
