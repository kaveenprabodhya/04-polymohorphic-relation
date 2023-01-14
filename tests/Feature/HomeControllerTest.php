<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_home_page_main_content()
    {
        $response = $this->get('/');

        $response->assertSeeText(
            'Welcome to Our Blog'
        );
    }

    public function test_contact_page_is_working_correctly()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
    }
}