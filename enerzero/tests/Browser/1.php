<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Welcome Back!')
                    ->ClickLink('Register')
                    ->assertPathIs('/regist')
                    ->type('username', 'hawari')
                    ->type('email', 'hawari@enerzero.com')
                    ->type('password', '12345678')
                    ->type('password_confirmation', '12345678')
                    ->press('Register');
        });
    }
}
