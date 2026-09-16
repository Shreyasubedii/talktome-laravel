<?php

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class ScheduleUpdateService
{
    public function update(Schedule $schedule, array $data): ?string
    {
        if ($schedule->appointments()->exists()) {
            return 'Booked availability slots cannot be edited.';
        }

        $overlappingSchedules = Schedule::where('docid', $schedule->docid)
            ->where('scheduleid', '!=', $schedule->scheduleid)
            ->where('scheduledate', $data['date'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->get();

        $bookedOverlap = $overlappingSchedules->first(function ($overlappingSchedule) {
            return $overlappingSchedule->appointments()->exists();
        });

        if ($bookedOverlap) {
            return 'This time overlaps with a booked availability slot.';
        }

        DB::transaction(function () use ($schedule, $overlappingSchedules, $data) {
            $overlappingSchedules->each->delete();

            $bookedCount = $schedule->appointments()->count();
            $remainingCapacity = max($data['nop'] - $bookedCount, 0);

            $schedule->update([
                'title' => $data['title'],
                'scheduledate' => $data['date'],
                'scheduletime' => $data['start_time'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time'],
                'nop' => $data['nop'],
                'remaining_capacity' => $remainingCapacity,
                'status' => $remainingCapacity > 0 ? 'available' : 'full',
                'is_full' => $remainingCapacity < 1,
            ]);
        });

        return null;
    }
}