<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\LandingPage;
use Tests\DuskTestCase;

class LandingPageTest extends DuskTestCase
{
    public function test_landing_page_contains_phase()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LandingPage)
                    ->assertSee('Phase');
        });
    }

    public function test_landing_page_contains_repo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LandingPage)
                    ->assertSee('reed-jones/phase');
        });
    }

    public function test_landing_page_contains_changelog()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LandingPage)
                    ->assertSee('Changelog');
        });
    }

    public function test_landing_page_contains_github_link() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LandingPage)
                ->click('@github-link')
                ->assertUrlIs('https://github.com/reed-jones/phase');
        });
    }

    public function test_landing_page_contains_documentation_link() {
        $this->browse(function (Browser $browser) {
            $browser->visit(new LandingPage)
                ->click('@docs-link')
                ->waitFor('@docs/getting-started')
                ->assertPathIs('/docs/master/getting-started');
        });
    }
}
