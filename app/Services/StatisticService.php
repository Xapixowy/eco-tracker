<?php

namespace App\Services;

use App\Exceptions\StatisticsUnableToRetrieveDueToEmissionRecordsNotFoundException;
use App\Http\Requests\StatisticRequest;
use App\Models\Home;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StatisticService
{
    public function index(array $params, User $user): array
    {
        $carbonFrom = isset($params[StatisticRequest::FROM_KEY]) ? Carbon::make($params[StatisticRequest::FROM_KEY]) : null;
        $carbonTo = isset($params[StatisticRequest::TO_KEY]) ? Carbon::make($params[StatisticRequest::TO_KEY]) : null;

        $vehicleEmissionRecords = $this->getEmissionRecordsBetweenDates(Carbon::make($carbonFrom), $carbonTo, $user->vehicles);
        $homeEmissionRecords = $this->getEmissionRecordsBetweenDates(Carbon::make($carbonFrom), $carbonTo, $user->homes);

        return $this->getStatisticBetweenDates($carbonFrom, $carbonTo, $vehicleEmissionRecords->merge($homeEmissionRecords)->sortBy('start_at'));
    }

    private function getEmissionRecordsBetweenDates(?Carbon $date_from, ?Carbon $date_to, Collection $resources): Collection
    {
        $emissionRecords = $resources->map(function (Vehicle|Home $resource) use ($date_from, $date_to) {
            $query = $resource->emissionRecords();

            if ($date_from) {
                $query->where('start_at', '>=', $date_from->toDateTimeString());
            }

            if ($date_to) {
                $query->where('end_at', '<=', $date_to->toDateTimeString());
            }

            return $query->get();
        })->flatten()->sortBy('start_at');


        if ($emissionRecords->isEmpty()) {
            return collect();
        }

        return $emissionRecords;
    }

    private function getStatisticBetweenDates(?Carbon $date_from, ?Carbon $date_to, Collection $resources): array
    {
        if ($resources->isEmpty()) {
            throw new StatisticsUnableToRetrieveDueToEmissionRecordsNotFoundException();
        }

        $start_date = $date_from ?? Carbon::make($resources->first()->start_at);
        $end_date = $date_to ?? Carbon::now();

        $emissionRecordDays = round($start_date->diffInDays($end_date));
        $emissionRecordDays = $emissionRecordDays > 0 ? $emissionRecordDays : 1;
        $averageNationalCo2PerDay = config('co2.average_national_co2_per_year') / 365;
        $co2EmissionSum = round($resources->sum('co2_emmision'), 2);

        $isAboveAverage = ($co2EmissionSum / $emissionRecordDays) > $averageNationalCo2PerDay;

        return [
            'co2_emission_days' => $emissionRecordDays,
            'co2_emission' => $co2EmissionSum,
            'co2_emission_national_average' => round($averageNationalCo2PerDay * $emissionRecordDays, 2),
            'message' => $this->getStatisticMessage($isAboveAverage),
        ];
    }

    private function getStatisticMessage(bool $isAboveAverage): string
    {
        return $isAboveAverage ? 'Your average CO2 emission is above the national average.' : 'Your average CO2 emission is below the national average.';
    }
}
