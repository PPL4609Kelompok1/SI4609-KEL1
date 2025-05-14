<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapDirectTest extends DuskTestCase
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
     * Test clicking Get Directions button on the favorites page
     * @group MapDirect
     */
    public function testGetDirectionsFromFavorites(): void
    {
        $this->browse(function (Browser $browser) {
            // First add a station to favorites
            $browser->visit('/map')
                    ->waitFor('#map')
                    ->waitUntil('return typeof map !== "undefined"')
                    ->waitFor('.leaflet-marker-icon', 20)
                    ->click('.leaflet-marker-icon')
                    ->waitFor('.station-popup', 10)
                    ->click('button[onclick*="toggleFavorite"]')
                    ->pause(1000);

            // Then go to favorites page and click Get Directions
            $browser->visit('/map/favorites')
                    ->waitFor('#favorites-list')
                    // Wait for favorites to load
                    ->pause(2000)
                    // Click the Get Directions button using its onclick attribute
                    ->click('button[onclick*="getDirections"]');
        });
    }
}
