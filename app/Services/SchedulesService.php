<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;

class SchedulesService
{
    public function listSchedules(string $day = null)
    {
        $date = $day != null ? Carbon::createFromFormat('Y-m-d', $day) : now();

        $today = now()->today();
       
        if ($date->isBefore($today)) {
            return ['data' => []];
        }

        $schedules = Schedule::with(['checkins' =>  function ($query) use ($date) {
            return $query->where('checkins.checkin_date', $date->format('Y-m-d'))
                ->where('checkins.status', '<>', 'canceled');
        }])
            ->where('day_of_week', $date->dayOfWeek)
            ->where(function($query) use ($date) {
                return $date->isToday() ? $query->where('hour', '>=', $date->format('H:i')) : $query;
            })
            ->where('active', true)
            ->orderBy('hour')
            ->get();


        $data = collect([]);
        $clientId = auth()->user()->client->id;
        $schedules->each(function ($schedule) use ($clientId, $date, $data) {
            $data->push(
                [
                    'id' => $schedule->id,
                    'day' => $date->format('Y-m-d'),
                    'hour'=> $schedule->hour,
                    'description'=> $schedule->description,
                    'professor'=> $schedule->professor,
                    'limit'=> $schedule->limit ,
                    'vacancies'=> $schedule->limit - $schedule->checkins->count(),
                    'userScheduled'=> $schedule->checkins->contains('client_id', $clientId),
                ]
            );
        });
        
        return $data->toArray();
    }
}
