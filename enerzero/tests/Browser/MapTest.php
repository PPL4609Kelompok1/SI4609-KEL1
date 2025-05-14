<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group MapLocation
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Selamat')
                ->clickLink('Map')
                ->assertPathIs('/map')
                ->waitFor('#map')
                ->waitFor('#currentLocation')
                ->waitFor('#map')
                ->assertScript('return map.getCenter() !== null', true)
                ->assertScript('return map.getZoom() !== null', true)
                ->assertScript('return currentUserLocation !== null', true);
        });
    }
}

