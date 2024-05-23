<?php

namespace Repositories;

use DateTime;
use Illuminate\Support\Collection;
use Models\Call;
use Models\NumberOperators;
use Models\Operator;
use Models\PhoneNumber;
use Models\User;

class CallsRepository
{
    public function getCallWithCalculatedData(int $perPage = 12, int $offset = 0): Collection
    {
        $calls = $this->getCallsFromDb($perPage, $offset);

        $allPhonesFromCall = $this->getPhonesFromCalls($calls);
        $phones = $allPhonesFromCall['phones'];
        $dialedPhones = $allPhonesFromCall['dialedPhones'];

        $numberOperatorsData = $this->getOperatorsWithListOfNumbers($allPhonesFromCall);
        $operatorsData = $this->getOperatorsDataWithPrices($numberOperatorsData);

        $calls = $calls->map(function ($item) use ($phones, $dialedPhones, $operatorsData) {
            $phone = $phones->where('id', $item['phone_id']);
            if ($phone) {
                $item['user'] = $phone->first()['user_id'];
            }

            $dialedPhone = $dialedPhones->where('id', $item['dialed_phone_id']);
            if ($dialedPhone) {
                $item['dialed_user'] = $dialedPhone->first()['user_id'];
            }

            $startTime = new DateTime($item['call_start_time']);
            $endTime = new DateTime($item['call_end_time']);
            $item['duration'] = $endTime->getTimestamp() - $startTime->getTimestamp();

            $numberOperator = $operatorsData->filter(function ($operator) use ($item) {
                return in_array($item['phone_id'], $operator['numbers']);
            });
            $dialedOperator = $operatorsData->filter(function ($operator) use ($item) {
                return in_array($item['dialed_phone_id'], $operator['numbers']);
            });
            if ($numberOperator->isNotEmpty() && $dialedOperator->isNotEmpty()) {
                if ($numberOperator->first()['operator_id'] == $dialedOperator->first()['operator_id']) {
                    $item['call_cost'] = $item['duration'] * $numberOperator->first()['prices']['internal_price'];
                } else {
                    $item['call_cost'] = ceil($item['duration'] / 60) * $numberOperator->first()['prices']['external_price'];
                }
            }
            return $item;
        });
        $users = $this->getUsersFromCalls($calls);
        $calls = $calls->map(function ($item) use ($users) {
            $item['user'] = $users['users']->where('id', $item['user'])->first()['email'];
            $item['dialed_user'] = $users['dialedUsers']->where('id', $item['dialed_user'])->first()['email'];
            return $item;
        });
        return $calls;
    }

    private function getCallsFromDb(int $perPage = 12, int $offset = 0): Collection
    {
        $call = new Call();
        return collect($call->all($perPage, $offset));
    }

    public function getPagination(): array
    {
        $call = new Call();
        $total = $call->getTotal();
        return [
            'total' => $total,
            'count_pages' => ceil($total / 12)
        ];
    }

    private function getPhonesFromCalls(Collection $calls): array
    {
        $phonesIds = $calls->pluck('phone_id')->toArray();
        $dialedPhonesIds = $calls->pluck('dialed_phone_id')->toArray();

        $phone = new PhoneNumber();
        $users = collect($phone->find($phonesIds));
        $dialedPhones = collect($phone->find($dialedPhonesIds));
        return [
            'phones' => $users,
            'dialedPhones' => $dialedPhones
        ];
    }

    private function getUsersFromCalls(Collection $calls): array
    {
        $usersIds = $calls->pluck('user')->toArray();
        $dialedUsersIds = $calls->pluck('dialed_user')->toArray();

        $user = new User();
        $users = collect($user->find($usersIds));
        $dialedUsers = collect($user->find($dialedUsersIds));
        return [
            'users' => $users,
            'dialedUsers' => $dialedUsers
        ];
    }

    private function getOperatorsWithListOfNumbers(array $phones): Collection
    {
        $phonesIds = $phones['phones']->pluck('id')->toArray();
        $dialedPhonesIds = $phones['dialedPhones']->pluck('id')->toArray();
        $numberOperators = new NumberOperators();
        return collect($numberOperators->getDataByNumberIds(array_merge($phonesIds, $dialedPhonesIds)));
    }

    private function getOperatorsDataWithPrices(Collection $numberOperatorsData)
    {
        $groupedData = $numberOperatorsData->groupBy('operator_id')->map(function ($item) {
            return ['numbers' => collect($item)->pluck('number_id')->toArray()];
        })->toArray();

        $operator = new Operator();
        $operatorsDataWithPrices = collect($operator->find($numberOperatorsData->pluck('operator_id')->toArray()));

        $operatorsData = [];
        foreach ($groupedData as $operatorId => $data) {
            $operator = $operatorsDataWithPrices->where('id', $operatorId)->first();
            $data['operator_id'] = $operatorId;
            $data['prices'] = [
                'internal_price' => $operator['internal_price'],
                'external_price' => $operator['external_price']
            ];
            $operatorsData[$operatorId] = $data;
        }
        return collect($operatorsData);
    }
}
