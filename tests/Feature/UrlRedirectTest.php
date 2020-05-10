<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlRedirectTest extends TestCase
{
    public function test_landing_page_returns_200_ok()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_docs_redirects_with_no_section()
    {
        $response = $this->get('/docs');
        $response->assertRedirect('/docs/master/getting-started');
    }

    public function test_docs_redirects_with_no_version()
    {
        $response = $this->get('/docs/getting-started');
        $response->assertRedirect('/docs/master/getting-started');
    }

    public function test_docs_redirects_from_not_existent_page_to_404_not_found()
    {
        $response = $this->get('/docs/master/not-existent');
        $response->assertStatus(404);
    }

    public function test_docs_with_version_and_section_returns_200_ok()
    {
        $response = $this->get('/docs/master/getting-started');
        $response->assertStatus(200);
    }

    public function test_landing_page_has_server_rendered_code_examples()
    {
        $response = $this->get('/');
        $response->assertSeeInOrder([
            '<pre ',
            'language-php',
            '<code ',
            'language-php',
            '</code>',
            '</pre>'
        ], $escaped = false);
    }

    public function test_getting_started_has_server_rendered_heading() {
        $response = $this->get('/docs/master/getting-started');
        $response->assertSee('<h1 id="getting-started">Getting Started</h1>', $escaped = false);
    }
}
