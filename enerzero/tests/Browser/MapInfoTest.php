<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapInfoTest extends DuskTestCase
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
     * Test clicking on a charging station marker to view its information
     * @group MapInfo
     */
    public function testViewChargingStationInfo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/map')
                    ->waitFor('#map')
                    // Wait for map to load and initialize
                    ->waitUntil('return typeof map !== "undefined"')
                    // Wait for markers to be loaded with longer timeout
                    ->waitFor('.leaflet-marker-icon', 20)
                    // Click on the first marker
                    ->click('.leaflet-marker-icon')
                    // Wait for popup to appear
                    ->waitFor('.station-popup', 10)
                    // Verify popup content
                    ->assertPresent('.station-popup')
                    ->assertPresent('h5.text-xl.font-bold.text-blue-800')
                    ->assertPresent('.location-details');
        });
    }
}
