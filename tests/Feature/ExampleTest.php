<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        // Menguji bahwa halaman login (yang boleh diakses tamu) berhasil dimuat
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}