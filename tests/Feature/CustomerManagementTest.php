<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_exact_location_is_saved_and_shown_on_dashboard(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $branch = Branch::forceCreate(['branch_name' => 'Main Branch']);
        $customerData = [
            'name' => 'Juan Cruz',
            'phone' => '09123456789',
            'branch_id' => $branch->id,
            'exact_location' => '12 Mabini Street, Barangay Centro',
        ];

        $this->actingAs($owner)
            ->post(route('owner.customers.store'), $customerData)
            ->assertRedirect(route('owner.customers'));

        $customer = Customer::query()->sole();
        $this->assertSame($customerData['exact_location'], $customer->exact_location);

        $this->actingAs($owner)
            ->get(route('owner.customers'))
            ->assertOk()
            ->assertSeeText('Customer Name')
            ->assertSeeText('Number')
            ->assertSeeText('Branch')
            ->assertSeeText('Exact Location')
            ->assertSeeText('Actions')
            ->assertSeeText($customerData['exact_location']);
    }
}