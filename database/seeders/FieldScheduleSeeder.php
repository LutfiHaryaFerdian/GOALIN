<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FieldScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $fields = Field::all();

        // Time slots: 07:00 to 22:00, 1-hour intervals
        $timeSlots = [];
        for ($hour = 7; $hour < 22; $hour++) {
            $timeSlots[] = [
                'start' => sprintf('%02d:00:00', $hour),
                'end'   => sprintf('%02d:00:00', $hour + 1),
            ];
        }

        // Create schedules for next 14 days
        foreach ($fields as $field) {
            for ($day = 0; $day < 14; $day++) {
                $date = Carbon::today()->addDays($day)->format('Y-m-d');

                foreach ($timeSlots as $slot) {
                    FieldSchedule::firstOrCreate([
                        'field_id'      => $field->id,
                        'schedule_date' => $date,
                        'start_time'    => $slot['start'],
                    ], [
                        'end_time' => $slot['end'],
                        'status'   => 'available',
                    ]);
                }
            }
        }
    }
}
