<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use DatabaseTransactions;

    protected $partner;

    protected function setUp(): void
    {
        parent::setUp();
        $parent = User::factory()->create();
        $partner = User::factory()->create();
        $this->actingAs($parent);
        Partner::create([
            'parent_id' => $parent->id,
            'partner_id' => $partner->id,
        ]);
        $this->partner = $partner;
    }

    public function test_get_parent_partners()
    {
        $response = $this->get('/api/partner');

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => "Data Loaded Successfully",
            "data" => [
                [
                    "partner_id" => $this->partner->id,
                    "partner_name" => $this->partner->name
                ]
            ]
        ]);
    }

    public function test_add_new_partner()
    {
        $response = $this->post('/api/partner', [
            'partner_id' => 1
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            "message" => "Partner Added Successfully",
        ]);
    }
    public function test_validation_when_add_new_partner()
    {
        $response = $this->post('/api/partner', [
            'partner_id' => 0
        ]);

        $response->assertStatus(302);
    }
}
