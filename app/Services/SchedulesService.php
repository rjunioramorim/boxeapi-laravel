<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;

class SchedulesService
{
    public function listSchedules(string $day)
    {
        $date = $day != null ? Carbon::createFromFormat('Y-m-d', $day) : now();

        $today = now()->today();

        if ($date->isBefore($today)) {
            return [];
        }

        $schedules = Schedule::with(['checkins' =>  function ($query) use ($date) {
            return $query->where('checkins.checkin_date', $date->format('Y-m-d'))
                ->where('checkins.status', '<>', 'canceled');
        }])
            ->where('day_of_week', $date->dayOfWeek)
            ->where(function ($query) use ($date) {
                return $date->isToday() ? $query->where('hour', '>=', $date->format('H:i')) : $query;
            })
            ->where('active', true)
            ->orderBy('hour')
            ->get();

        return $schedules;
    }

    public function getSchedule(Schedule $schedule, string $date)
    {
        $schedule = Schedule::with(['checkins.client.user'], function ($query) use ($date) {
            return $query->where('checkins.checkin_date', $date)->where('checkins.status', '<>', 'canceled');
        })->where('schedules.active', true)
            ->where('schedules.id', $schedule->id)
            ->first();

        return $schedule;
    }
}
