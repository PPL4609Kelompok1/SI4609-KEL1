<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapFavoriteTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }

    /**
     * Test clicking the star button in location info popup
     * @group MapFavorite
     */
    public function testClickStarButton(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/map')
                    ->waitFor('#map')
                    // Wait for map to load and initialize
                    ->waitUntil('return typeof map !== "undefined"')
                    // Wait for markers to be loaded
                    ->waitFor('.leaflet-marker-icon', 20)
                    // Click on the first marker
                    ->click('.leaflet-marker-icon')
                    // Wait for popup to appear
                    ->waitFor('.station-popup', 10)
                    // Click the star button
                    ->click('button[onclick*="toggleFavorite"]')
                    // Wait a bit for the action to complete
                    ->pause(1000);
        });
    }
}
