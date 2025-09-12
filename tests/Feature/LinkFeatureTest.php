<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_shorten_a_url()
    {
        $url = 'https://example.com/very-long-url';

        $response = $this->post(route('links.store'), [
            'original_url' => $url,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('link');
        $this->assertDatabaseHas('links', ['original_url' => $url]);
    }

    /** @test */
    public function short_link_redirects_to_original_url_and_increments_clicks()
    {
        $link = Link::factory()->create(['clicks' => 5]);

        $response = $this->get(route('links.show', $link->short_code));

        $response->assertStatus(301);
        $response->assertRedirect($link->original_url);

        // ใช้ fresh() เพื่อดึงข้อมูลล่าสุดจาก DB หลังการ redirect
        $this->assertEquals(6, $link->fresh()->clicks);
    }

    /** @test */
    public function guest_is_redirected_from_dashboard_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_see_their_dashboard_with_their_links()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $linkOwnedByUser = Link::factory()->create(['user_id' => $user->id]);
        $linkNotOwnedByUser = Link::factory()->create(); // ลิงก์ของคนอื่น

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee($linkOwnedByUser->original_url);
        $response->assertDontSee($linkNotOwnedByUser->original_url);
    }
}
