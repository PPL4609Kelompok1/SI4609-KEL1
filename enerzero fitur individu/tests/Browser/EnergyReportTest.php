<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
   
    

class EnergyReportTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @group EnergyReport
     */
    public function test_energy_report_page_shows_analysis()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:8000/energy-report')
                    ->assertSee('Energy Usage Report')
                    ->clickLink('Energy Usage Report')
                    ->assertSee('Monthly Comparison')
                    ->assertSee('Current Month Usage')
                    ->assertSee('Analysis & Recommendations')
                    ->assertSee('Previous Month');
        });
    }
}
