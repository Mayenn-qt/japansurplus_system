<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedRouteAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_access_owner_routes(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $this->actingAs($owner)
            ->get(route('owner.product'))
            ->assertOk();
    }

    public function test_staff_cannot_access_owner_routes(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)
            ->get(route('owner.product'))
            ->assertForbidden();
    }

    public function test_staff_can_access_staff_routes(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)
            ->get(route('staff.products.index'))
            ->assertOk();
    }

    public function test_owner_cannot_access_staff_routes(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $this->actingAs($owner)
            ->get(route('staff.products.index'))
            ->assertForbidden();
    }
}