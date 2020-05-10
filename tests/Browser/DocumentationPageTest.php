<?php

namespace Tests\Browser;

use App\Section;
use App\Version;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\DocumentationPage;
use Tests\DuskTestCase;

class DocumentationPageTest extends DuskTestCase
{
    public function test_main_docs_page_redirects_to_getting_started()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/docs')
                ->on(new DocumentationPage(Version::byTag('master')->first(), Section::firstWhere('slug', 'getting-started')))
                ->assertPathIs('/docs/master/getting-started');
        });
    }

    public function test_omitting_branch_redirects_to_master()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/docs/server-side-rendering')
                ->on(new DocumentationPage(Version::byTag('master')->first(), Section::firstWhere('slug', 'server-side-rendering')))
                ->assertPathIs('/docs/master/server-side-rendering');
        });
    }

    public function test_all_section_links_work_properly()
    {
        $this->browse(function (Browser $browser) {

            $version = Version::byTag('master')->first();

            foreach ($version->sections as $section) {
                $browser->visit('/docs')
                    ->click("@sidebar/{$section->slug}")
                    ->waitFor("@docs/{$section->slug}")
                    ->assertPathIs("/docs/{$version->branch}/{$section->slug}")
                    ->assertSee("Phase");
            }
        });
    }
}
