<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapDeleteTest extends DuskTestCase
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
     * Test deleting a favorite station
     * @group MapDelete
     */
    public function testDeleteFavorite(): void
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

            // Then go to favorites page and delete the station
            $browser->visit('/map/favorites')
                    ->waitFor('#favorites-list')
                    // Wait for favorites to load
                    ->pause(2000)
                    // Click the delete (trash) button
                    ->click('button[onclick*="removeFavorite"]')
                    // Wait for the list to update
                    ->pause(1000)
                    // Verify the station was removed
                    ->assertScript('return JSON.parse(localStorage.getItem("chargingStationFavorites") || "[]").length', 0);
        });
    }
}
