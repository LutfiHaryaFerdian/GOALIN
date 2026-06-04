<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FieldController;
use App\Models\Field;
use App\Models\FieldSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ScheduleController extends Controller
{
    public function index(Field $field)
    {
        $this->authorizeOwner($field);

        $dates = [];
        for ($i = 0; $i < 14; $i++) {
            $dates[] = Carbon::today()->addDays($i)->format('Y-m-d');
        }

        $schedules = $field->schedules()
            ->select(['id', 'field_id', 'schedule_date', 'start_time', 'end_time', 'status', 'notes'])
            ->whereIn('schedule_date', $dates)
            ->orderBy('schedule_date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($s) => $s->schedule_date->format('Y-m-d'));

        return view('owner.schedules.index', [
            'field'     => $field,
            'schedules' => $schedules,
            'dates'     => $dates,
        ]);
    }

    public function store(Request $request, Field $field)
    {
        $this->authorizeOwner($field);

        $request->validate([
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time'    => ['required', 'date_format:H:i'],
            'end_time'      => ['required', 'date_format:H:i', 'after:start_time'],
            'notes'         => ['nullable', 'string', 'max:255'],
        ]);

        FieldSchedule::firstOrCreate([
            'field_id'      => $field->id,
            'schedule_date' => $request->schedule_date,
            'start_time'    => $request->start_time . ':00',
        ], [
            'end_time' => $request->end_time . ':00',
            'status'   => 'available',
            'notes'    => $request->notes,
        ]);

        // Invalidate cached schedules for this field so public page reflects new slot
        FieldController::forgetScheduleCache($field->id);

        return redirect()->back()->with('success', 'Slot jadwal berhasil ditambahkan.');
    }

    public function updateStatus(Request $request, FieldSchedule $schedule)
    {
        $this->authorizeOwner($schedule->field);

        $request->validate([
            'status' => ['required', 'in:available,closed'],
            'notes'  => ['nullable', 'string', 'max:255'],
        ]);

        if ($schedule->status === 'booked') {
            return redirect()->back()->with('error', 'Slot yang sudah dipesan tidak dapat diubah.');
        }

        $schedule->update([
            'status' => $request->status,
            'notes'  => $request->notes,
        ]);

        // Invalidate cached schedules so users see the closed slot immediately
        FieldController::forgetScheduleCache($schedule->field_id);

        return redirect()->back()->with('success', 'Status slot berhasil diperbarui.');
    }

    public function updateHours(Request $request, FieldSchedule $schedule)
    {
        $this->authorizeOwner($schedule->field);

        if ($schedule->status === 'booked') {
            return redirect()->back()->with('error', 'Slot yang sudah dipesan tidak dapat diubah.');
        }

        $request->validate([
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        // Ensure update doesn't violate unique constraints for another slot
        $exists = FieldSchedule::where('field_id', $schedule->field_id)
            ->where('schedule_date', $schedule->schedule_date)
            ->where('start_time', $request->start_time . ':00')
            ->where('id', '!=', $schedule->id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Slot dengan jam mulai tersebut sudah terdaftar pada tanggal ini.');
        }

        $schedule->update([
            'start_time' => $request->start_time . ':00',
            'end_time'   => $request->end_time . ':00',
            'notes'      => $request->notes,
        ]);

        FieldController::forgetScheduleCache($schedule->field_id);

        return redirect()->back()->with('success', 'Jam slot berhasil diperbarui.');
    }

    public function destroy(FieldSchedule $schedule)
    {
        $this->authorizeOwner($schedule->field);

        if ($schedule->status === 'booked') {
            return redirect()->back()->with('error', 'Slot yang sudah dipesan tidak dapat dihapus.');
        }

        $schedule->delete();

        FieldController::forgetScheduleCache($schedule->field_id);

        return redirect()->back()->with('success', 'Slot jadwal berhasil dihapus.');
    }

    private function authorizeOwner(Field $field): void
    {
        if ($field->owner_id !== Auth::id()) {
            abort(403);
        }
    }
}
