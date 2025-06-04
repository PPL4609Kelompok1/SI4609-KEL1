<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group LoginTest
     */
    public function testUserCanLoginAndSeeDashboard(): void
    {
     $this->browse(function (Browser $browser) {
        $browser->visit('/login')
                ->type('username', 'fghj')
                ->type('password', 'fghjfghj') 
                ->press('LOGIN')               
                ->assertPathIs('/dashboard')      
                ->assertSee('Dashboard')           
                ->assertSee('Hai! Selamat datang');
        });
    }
}
