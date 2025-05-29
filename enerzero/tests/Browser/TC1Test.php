<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC1Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group tc1
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Welcome')
                    ->clinkLink('register')
                    ->pause(600)
                    ->assertPathIs('/regist');
        });
    }
}
