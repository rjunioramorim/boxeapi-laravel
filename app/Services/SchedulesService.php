<?php

namespace App\Services;

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;

class SchedulesService
{
    public function listSchedules(string $day = null)
    {
        $date = $day != null ? Carbon::createFromFormat('Y-m-d') : now();

        $schedules = Schedule::with(['checkins' =>  function ($query) use ($date) {
            return $query->where('checkins.checkin_date', $date->format('Y-m-d'))
                ->where('checkins.status', '<>', 'canceled');
        }])
            ->where('day_of_week', $date->dayOfWeek)
            ->where('hour', '>=', $date->format('H:i'))
            ->where('active', true)
            ->orderBy('hour')
            ->get();


        $clientId = auth()->user()->client->id;
        $schedules->each(function ($schedule) use ($clientId, $date) {
            $schedule->day = $date->format('Y-m-d');
            $schedule->vacancies = $schedule->limit - $schedule->checkins->count();
            $schedule->userScheduled = $schedule->checkins->contains('client_id', $clientId);
            $schedule->userStatus = $schedule->checkins->where('status', '<>', ScheduleType::CANCELED->value)->pluck('status')->last();
        });
        return $schedules;
    }
}
