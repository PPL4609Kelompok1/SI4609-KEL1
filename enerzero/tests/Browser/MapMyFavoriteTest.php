<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class MapMyFavoriteTest extends DuskTestCase
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
     * Test accessing the My Favorites page
     * @group MapMyFavorite
     */
    public function testAccessMyFavoritesPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/map')
                    ->waitFor('#map')
                    // Click on My Favorites link
                    ->click('a[href*="map/favorites"]')
                    // Verify we're on the favorites page
                    ->assertPathIs('/map/favorites')
                    // Verify the page title is present
                    ->assertSee('My Favorite Charging Stations');
        });
    }
}
