<?php

namespace App\Services;

use App\Enums\ScheduleType;
use App\Models\Checkin;
use App\Models\Schedule;
use Carbon\Carbon;
use Exception;

class CheckinsService
{
    public function listCheckins()
    {
        $user = auth()->user();
        $today = now()->format('Y-m-d');

        $checkins = Checkin::with('schedule')
            ->where('client_id', $user->client->id)
            ->where('checkin_date', '>=', $today)
            ->orderBy('checkin_date')
            ->orderBy('hour')
            ->get();

        return $checkins;
    }

    public function createCheckin($data)
    {
        $this->verifyUserActive();
        $this->vefiryHourCheckin($data);
        $this->vefiryCheckinLimit($data);
        $this->vefiryCheckinCreated($data);

        return $this->saveCheckin($data);
    }

    private function saveCheckin($data)
    {
        $clientId = auth()->user()->client->id;
        $checkin = Checkin::create([
            'schedule_id' => $data['schedule_id'],
            'hour' => $data['hour'],
            'checkin_date' => $data['checkin_date'],
            'client_id' => $clientId,
        ]);
        return $checkin;
    }


    private function vefiryHourCheckin($data)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d', $data['checkin_date']);
        $today = $dateTime->isSameDay(now());
        $isFuture = $dateTime->isAfter(now());

        $schedule = Schedule::find($data['schedule_id'])->first();

        if (($today && $dateTime->format('H:i') < $schedule->hour) || $isFuture) {
            return;
        }
        throw new Exception('A aula já começou e não está mais disponível, tente outro horário');
    }

    private function vefiryCheckinCreated($data)
    {
        $checkin = Checkin::where('schedule_id', $data['schedule_id'])
            ->whereDate('checkin_date', $data['checkin_date'])
            ->where('hour', $data['hour'])
            ->where('client_id', auth()->user()->client->id)
            ->where('status', '<>', ScheduleType::CANCELED->value)->count();
        if ($checkin > 0) {
            throw new Exception('Você já tem uma aula agendada para esse horário');
        }
    }

    private function vefiryCheckinLimit($data)
    {
        $schedule = Schedule::find($data['schedule_id'])->first();

        $checkin = Checkin::where('schedule_id', $data['schedule_id'])
            ->where('checkin_date', $data['checkin_date'])
            ->where('hour', $data['hour'])
            ->where('status', '<>', ScheduleType::CANCELED->value)->count();

        if ($checkin >= $schedule->limit) {
            throw new Exception('Ops... Essa aula não tem mais vagas, tente outro horário');
        }
    }

    private function verifyUserActive() {
        if (auth()->user()->active ==false) {
            throw new Exception('Não foi possível realizar o agendamento. Entre em contato com a administração.');
        }
    }

    
}
