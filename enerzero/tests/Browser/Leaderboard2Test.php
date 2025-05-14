<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Leaderboard2Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group Leaderboard2
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('username','sarahlukir')
                    ->type('password','sarahsarah1')
                    ->press('LOGIN')
                    ->assertPathIs('/dashboard')
                    ->clickLink('Leaderboard')
                    ->assertPathIs('/leaderboard')
                    ->clickLink('Komunitas')
                    ->assertPathIs('/leaderboard/komunitas')
                    ->clickLink('Wilayah')
                    ->assertPathIs('/leaderboard/wilayah');
        });
    }
}
