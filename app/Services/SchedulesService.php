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
    
        return $schedules;    
        // $data = collect([]);
        // $clientId = auth()->user()->client->id;
        // $schedules->each(function ($schedule) use ($clientId, $date, $data) {
        //     $data->push(
        //         [
        //             'id' => $schedule->id,
        //             'day' => $date->format('Y-m-d'),
        //             'hour'=> $schedule->hour,
        //             'description'=> $schedule->description,
        //             'professor'=> $schedule->professor,
        //             'limit'=> $schedule->limit ,
        //             'vacancies'=> $schedule->limit - $schedule->checkins->count(),
        //             'userScheduled'=> $schedule->checkins->contains('client_id', $clientId),
        //         ]
        //     );
        // });
        
        // return $data->toArray();
    }


    public function getSchedule(Schedule $schedule, string $date)
    {
        $schedule = Schedule::with(['checkins.client.user'], function ($query) use ($date) {
            return $query->where('checkins.checkin_date', $date)->where('checkins.status', '<>', 'canceled');
        })->where('schedules.active', true)
          ->where('schedules.id', $schedule->id)
          ->first();

        // $schedule = Schedule::with(['checkins.client.user'], function ($query) use ($day) {
            //     return $query->where('checkins.checkin_date', $day)->where('checkins.status', '!=', ScheduleType::CANCELED->value);
            // })->where('id', $schedule->id)->first();

        return $schedule;
        
        // $clientId = auth()->user()->client->id;
        
        // $data = [
        //     'id' => $schedule->id,
        //     'day' => $date,
        //     'hour'=> $schedule->hour,
        //     'description'=> $schedule->description,
        //     'professor'=> $schedule->professor,
        //     'limit'=> $schedule->limit ,
        //     'vacancies'=> $schedule->limit - $schedule->checkins->count(),
        //     'clients' => $this->listCheckins($schedule->checkins, $clientId) ,
        // ];

        // dd($data);
        // return $data;
    }

    // private function listCheckins($checkins, $clientId){
    //     $data = collect();
    //     $checkins->each(function($checkin) use($data, $clientId){
    //         $data->push([
    //             'id' => $checkin->id,
    //             'status' => $checkin->status,
    //             'isOwner' => $checkin->client_id == $clientId,
    //             'name' => $checkin->client->user->name,
    //             'avatar_url' => url($checkin->client->user->avatar_url)
    //         ])->toArray();
    //     });
    //    return $data->toArray();
    // }
}
