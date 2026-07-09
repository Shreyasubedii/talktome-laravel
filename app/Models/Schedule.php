<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $primaryKey = 'scheduleid';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $table = 'schedule';
    public $timestamps = false;
    
    protected $fillable = ['docid', 'title', 'scheduledate', 'scheduletime', 'nop', 'start_time', 'end_time', 'status', 'remaining_capacity', 'is_full'];

    protected $casts = [
        'scheduledate' => 'date',
        'is_full' => 'boolean',
        'remaining_capacity' => 'integer',
        'nop' => 'integer',
    ];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'docid', 'docid');
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'scheduleid', 'scheduleid');
    }

    public function isBookable(): bool
    {
        if ($this->is_full || $this->status !== 'available') {
            return false;
        }

        if ($this->scheduledate->lt(now()->toDateString())) {
            return false;
        }

        return $this->remaining_capacity > 0;
    }

    public function markAsFull(): void
    {
        $this->update([
            'remaining_capacity' => 0,
            'is_full' => true,
            'status' => 'full',
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'available')->where('is_full', false);
    }

    public static function buildThirtyMinuteSlots(string $title, string $date, string $startTime, string $endTime, int $maxPatients): array
    {
        $slots = [];
        $start = new \DateTimeImmutable($date . ' ' . $startTime);
        $end = new \DateTimeImmutable($date . ' ' . $endTime);
        $interval = new \DateInterval('PT30M');

        $cursor = $start;
        while ($cursor < $end) {
            $slotEnd = $cursor->add($interval);
            if ($slotEnd > $end) {
                break;
            }

            $slots[] = [
                'title' => $title,
                'scheduledate' => $date,
                'scheduletime' => $cursor->format('H:i:s'),
                'start_time' => $cursor->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'nop' => $maxPatients,
                'remaining_capacity' => $maxPatients,
                'status' => 'available',
                'is_full' => false,
            ];

            $cursor = $slotEnd;
        }

        return $slots;
    }
}