<?php

namespace Tests\Browser\Pages;

use App\Section;
use App\Version;
use Laravel\Dusk\Browser;

class DocumentationPage extends Page
{
    protected $version;
    protected $section;

    public function __construct(Version $version = null, Section $section){
           $this->version = $version;
           $this->section = $section;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return "/docs/{$this->version->branch}/{$this->section->slug}";
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
