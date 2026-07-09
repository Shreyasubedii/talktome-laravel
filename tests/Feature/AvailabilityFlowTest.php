<?php

namespace Tests\Feature;

use App\Models\Schedule;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AvailabilityFlowTest extends TestCase
{
    public function test_admin_schedule_store_route_exists(): void
    {
        $this->assertTrue(Route::has('admin.schedules.store'));
    }

    public function test_doctor_schedule_update_route_exists(): void
    {
        $this->assertTrue(Route::has('doctor.schedules.update'));
    }

    public function test_admin_schedule_store_and_update_routes_exist(): void
    {
        $this->assertTrue(Route::has('admin.schedules.store'));
        $this->assertTrue(Route::has('admin.schedules.update'));
    }

    public function test_admin_doctor_and_patient_update_routes_exist(): void
    {
        $this->assertTrue(Route::has('admin.doctors.update'));
        $this->assertTrue(Route::has('admin.patients.update'));
    }

    public function test_thirty_minute_slots_are_built_from_a_window(): void
    {
        $slots = Schedule::buildThirtyMinuteSlots('Demo', '2026-07-10', '09:00', '10:00', 1);

        $this->assertCount(2, $slots);
        $this->assertSame('09:00:00', $slots[0]['start_time']);
        $this->assertSame('09:30:00', $slots[0]['end_time']);
        $this->assertSame('09:30:00', $slots[1]['start_time']);
        $this->assertSame('10:00:00', $slots[1]['end_time']);
    }
}
