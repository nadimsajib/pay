<?php

namespace Tests\Browser;



use Faker\Core\File;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * From this testBasicExample method automatic test of our current method . This method browse given route
     * and upload sample CSV and submit the CSV and give a result
     *
     * @param Browser $browser
     *
     * @author Nadimul Haque
     * @return boolean
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->attach('get_file', storage_path('test_csv.csv'))
                ->press('Calculate')
                ->assertSee('successfully calculate commissions');
        });
    }
}
