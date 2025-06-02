<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

class NullControlTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    #[Test]
    #[Group('NullControl')]
    public function test_Null()
    {
        $this->browse(function (Browser $browser) {
            // Use consistent host naming (either localhost or 127.0.0.1)
            $browser->visit('http://127.0.0.1:8000/energy-report')
                    ->assertSee('Energy Usage Report')
                    ->clickLink('Energy Usage Report')
                    ->assertSee('Monthly Comparison')
                    ->assertSee('Current Month Usage')
                    ->assertSee('Analysis & Recommendations')
                    ->assertSee('Previous Month')
                    ->clickLink('+ Input Data')
                    ->assertPathIs('/energy/create') // Remove host from path assertion
                    ->
                    ->press('Save')

        });
    }
}