<?php

namespace Tests\Browser;



use Faker\Core\File;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
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
