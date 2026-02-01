<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------
    // 1. Admin and Member can't create short urls
    //    → Flipped: Admin and Member CAN create short urls
    // ---------------------------------------------------------------

    public function test_admin_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $admin   = User::factory()->admin($company->id)->create();

        $response = $this->actingAs($admin)->post('/urls', [
            'original_url' => 'https://example.com/test',
        ]);

        $response->assertRedirect(route('short-urls.index'));
        $this->assertDatabaseCount('short_urls', 1);
    }

    public function test_member_can_create_short_url(): void
    {
        $company = Company::factory()->create();
        $member  = User::factory()->member($company->id)->create();

        $response = $this->actingAs($member)->post('/urls', [
            'original_url' => 'https://example.com/test',
        ]);

        $response->assertRedirect(route('short-urls.index'));
        $this->assertDatabaseCount('short_urls', 1);
    }

    // ---------------------------------------------------------------
    // 2. SuperAdmin cannot create short urls
    //    → Stays as-is: SuperAdmin CANNOT create
    // ---------------------------------------------------------------

    public function test_super_admin_cannot_create_short_url(): void
    {
        $superAdmin = User::factory()->superAdmin()->create();

        $response = $this->actingAs($superAdmin)->post('/urls', [
            'original_url' => 'https://example.com/test',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseCount('short_urls', 0);
    }

    // ---------------------------------------------------------------
    // 3. Admin can only see the list of all short urls created
    //    in their own company
    // ---------------------------------------------------------------

    public function test_admin_can_only_see_urls_in_own_company(): void
    {
        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $adminA  = User::factory()->admin($companyA->id)->create();
        $memberA = User::factory()->member($companyA->id)->create();
        $memberB = User::factory()->member($companyB->id)->create();

        // URL in company A
        ShortUrl::factory()->create([
            'original_url' => 'https://company-a-url.com',
            'company_id'   => $companyA->id,
            'created_by'   => $memberA->id,
        ]);

        // URL in company B
        ShortUrl::factory()->create([
            'original_url' => 'https://company-b-url.com',
            'company_id'   => $companyB->id,
            'created_by'   => $memberB->id,
        ]);

        $response = $this->actingAs($adminA)->get('/urls');

        $response->assertStatus(200);
        $response->assertSee('company-a-url.com');
        $response->assertDontSee('company-b-url.com');
    }

    // ---------------------------------------------------------------
    // 4. Member can only see the list of all short urls created
    //    by themselves
    // ---------------------------------------------------------------

    public function test_member_can_only_see_own_urls(): void
    {
        $company = Company::factory()->create();

        $member1 = User::factory()->member($company->id)->create();
        $member2 = User::factory()->member($company->id)->create();

        ShortUrl::factory()->create([
            'original_url' => 'https://member1-url.com',
            'company_id'   => $company->id,
            'created_by'   => $member1->id,
        ]);

        ShortUrl::factory()->create([
            'original_url' => 'https://member2-url.com',
            'company_id'   => $company->id,
            'created_by'   => $member2->id,
        ]);

        $response = $this->actingAs($member1)->get('/urls');

        $response->assertStatus(200);
        $response->assertSee('member1-url.com');
        $response->assertDontSee('member2-url.com');
    }

    // ---------------------------------------------------------------
    // 5. Short urls are publicly resolvable and redirect to the
    //    original url
    // ---------------------------------------------------------------

    public function test_short_url_is_publicly_resolvable_and_redirects(): void
    {
        $company = Company::factory()->create();
        $member  = User::factory()->member($company->id)->create();

        $shortUrl = ShortUrl::factory()->create([
            'original_url' => 'https://example.com/destination',
            'short_code'   => 'abcdef',
            'company_id'   => $company->id,
            'created_by'   => $member->id,
        ]);

        // No actingAs — request is unauthenticated (public)
        $response = $this->get('/abcdef');

        $response->assertStatus(302);
        $response->assertRedirect('https://example.com/destination');
    }
}
