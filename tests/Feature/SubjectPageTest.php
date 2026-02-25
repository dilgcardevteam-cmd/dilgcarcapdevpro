<?php

namespace Tests\Feature;

use Tests\TestCase;

class SubjectPageTest extends TestCase
{
    /**
     * Test if the landing page displays the subject links.
     */
    public function test_landing_page_has_subject_links()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Core Governance');
        $response->assertSee(route('subject.show', 'core-governance-administration'), false);
    }

    /**
     * Test if a valid subject detail page loads correctly.
     */
    public function test_subject_detail_page_loads()
    {
        $response = $this->get(route('subject.show', 'core-governance-administration'));

        $response->assertStatus(200);
        $response->assertSeeText('Core Governance');
        $response->assertSee('Local Government Code'); // Part of the content
        $response->assertSee('Back to Subject Areas');
    }

    /**
     * Test if an invalid subject slug returns a 404.
     */
    public function test_invalid_subject_returns_404()
    {
        $response = $this->get(route('subject.show', 'non-existent-subject'));

        $response->assertStatus(404);
    }
}
