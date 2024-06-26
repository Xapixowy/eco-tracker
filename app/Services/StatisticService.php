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
    private EmissionRecordService $emissionRecordService;

    public function __construct(EmissionRecordService $emissionRecordService)
    {
        $this->emissionRecordService = $emissionRecordService;
    }

    public function index(array $params, User $user): array
    {
        return $this->buildVehiclesStatistic($params, $user);
    }

    private function buildVehiclesStatistic(array $params, User $user): array
    {
        $carbonFrom = isset($params[StatisticRequest::FROM_KEY]) ? Carbon::make($params[StatisticRequest::FROM_KEY]) : null;
        $carbonTo = isset($params[StatisticRequest::TO_KEY]) ? Carbon::make($params[StatisticRequest::TO_KEY]) : null;

        $vehicleEmissionRecords = $this->getEmissionRecordsBetweenDates(Carbon::make($carbonFrom), $carbonTo, $user->vehicles);

        dd($vehicleEmissionRecords);

        $vehicleEmissionRecords = $user->vehicles->map(function (Vehicle $vehicle) use ($params) {
            $query = $vehicle->emissionRecords();

            if (isset($params[StatisticRequest::FROM_KEY])) {
                $query->where('start_at', '>=', Carbon::make($params[StatisticRequest::FROM_KEY])->toDateTimeString());
            }

            if (isset($params[StatisticRequest::TO_KEY])) {
                $query->where('end_at', '<=', Carbon::make($params[StatisticRequest::TO_KEY])->toDateTimeString());
            }

            return $query->get();
        })->flatten()->sortBy('start_at');

        if ($vehicleEmissionRecords->isEmpty()) {
            throw new StatisticsUnableToRetrieveDueToEmissionRecordsNotFoundException();
        }

        $carbonFrom = isset($params[StatisticRequest::FROM_KEY]) ? Carbon::make($params[StatisticRequest::FROM_KEY]) : Carbon::make($vehicleEmissionRecords->first()->start_at);
        $carbonTo = isset($params[StatisticRequest::TO_KEY]) ? Carbon::make($params[StatisticRequest::TO_KEY]) : Carbon::now();

        $vehicleEmissionRecordDays = $carbonFrom->diffInDays($carbonTo);
        $averageNationalCo2PerDay = config('co2.average_national_co2_per_year') / 365;
        $co2EmissionSum = round($vehicleEmissionRecords->sum('co2_emmision'), 2);

        $isAboveAverage = ($co2EmissionSum / $vehicleEmissionRecordDays) > $averageNationalCo2PerDay;

        return [
            'co2_emission' => $co2EmissionSum,
            'is_above_average' => $isAboveAverage,
        ];
    }

    private function getEmissionRecordsBetweenDates(?Carbon $date_from, ?Carbon $date_to, Collection $resources): array
    {
        $emissionRecords = $resources->map(function (Vehicle|Home $resource) use ($date_from, $date_to) {
            $query = $resource->emissionRecords();

            if (isset($params[StatisticRequest::FROM_KEY])) {
                $query->where('start_at', '>=', $date_from->toDateTimeString());
            }

            if (isset($params[StatisticRequest::TO_KEY])) {
                $query->where('end_at', '<=', Carbon::make($params[StatisticRequest::TO_KEY])->toDateTimeString());
            }

            return $query->get();
        })->flatten()->sortBy('start_at');

        if ($emissionRecords->isEmpty()) {
            throw new StatisticsUnableToRetrieveDueToEmissionRecordsNotFoundException();
        }

        return $emissionRecords->toArray();
    }

    private function getStatisticBetweenDates(?Carbon $date_from, ?Carbon $date_to, Collection $resources): array
    {
        $start_date = $date_from ?? Carbon::make($resources->first()->start_at);
        $end_date = $date_to ?? Carbon::now();

        $emissionRecordDays = $start_date->diffInDays($end_date);
        $averageNationalCo2PerDay = config('co2.average_national_co2_per_year') / 365;
        $co2EmissionSum = round($resources->sum('co2_emmision'), 2);

        $isAboveAverage = ($co2EmissionSum / $emissionRecordDays) > $averageNationalCo2PerDay;

        return [
            'co2_emission_range' => $co2EmissionSum,
            'co2_emission' => $co2EmissionSum,
            'co2_emission_national_average' => $averageNationalCo2PerDay * $emissionRecordDays,
            'message' => $this->getStatisticMessage($isAboveAverage),
        ];
    }

    private function getStatisticMessage(bool $isAboveAverage): string
    {
        return $isAboveAverage ? 'Your average CO2 emission is above the national average.' : 'Your average CO2 emission is below the national average.';
    }
}
