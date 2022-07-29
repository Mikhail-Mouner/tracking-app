<?php

namespace Tests\Feature;

use App\Models\Baby;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class BabyTest extends TestCase
{
    use DatabaseTransactions;

    protected $baby;

    protected function setUp(): void
    {
        parent::setUp();
        $parent = User::factory()->create();
        $baby = Baby::create([
            'name' => 'Baby\'s Name',
            'parent_id' => $parent->id
        ]);
        $this->baby = $baby;
        $this->actingAs($parent);
    }

    public function test_show_all_babies_with_parent()
    {
        $response = $this->get('/api/baby');

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Data Loaded Successfully',
            "data" => [
                "babies" => [
                    [

                        "baby_id" => $this->baby->id,
                        "baby_name" => $this->baby->name
                    ]
                ],
                "partners_baby" => []/*[
                    "baby_id" => $this->baby->id,
                    "baby_name" => $this->baby->name,
                    "parent" => $this->partner->name
                ]*/,
            ]
        ]);
    }

    public function test_show_all_parent_babies()
    {

        $response = $this->get('/api/parent/babies');

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Data Loaded Successfully',
            "data" => [
                [
                    "baby_id" => $this->baby->id,
                    "baby_name" => $this->baby->name
                ]
            ]
        ]);
    }

    public function test_add_new_baby()
    {
        $response = $this->post('/api/baby', [
            'name' => 'Baby Test'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Baby Added Successfully',
        ]);
    }

    public function test_show_one_baby()
    {

        $response = $this->get('/api/baby/' . $this->baby->id);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Data Loaded Successfully',
            "data" => [
                "baby_id" => $this->baby->id,
                "baby_name" => $this->baby->name
            ]
        ]);
    }

    public function test_update_baby()
    {
        $response = $this->put('/api/baby/'.$this->baby->id, [
            'name' => 'Baby Test'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Baby Updated Successfully',
        ]);
    }

    public function test_delete_parent_baby()
    {
        $response = $this->delete('/api/baby/'.$this->baby->id);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "message" => 'Baby Removed Successfully',
        ]);
    }

    public function test_delete_another_baby()
    {
        $response = $this->delete('/api/baby/1');

        $response->assertStatus(409);
        $response->assertJson([
            "success" => false,
            "message" => 'Only His Parent Has Access To Delete This Baby',
        ]);
    }
}
