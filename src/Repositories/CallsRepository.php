<?php

namespace Repositories;

use DateTime;
use Illuminate\Support\Collection;
use Models\Call;
use Models\Operator;
use Models\User;
use Models\UserStatements;

class CallsRepository
{
    public function getCallWithCalculatedData(): Collection
    {
        $calls = $this->getCallsFromDb();

        $allUsersFromCall = $this->getUsersFromCalls($calls);
        $users = $allUsersFromCall['users'];
        $dialedUsers = $allUsersFromCall['dialedUsers'];

        $userStatementsData = $this->getOperatorsWithListOfUsers($allUsersFromCall);
        $operatorsData = $this->getOperatorsDataWithPrices($userStatementsData);

        $calls = $calls->map(function ($item) use ($users, $dialedUsers, $operatorsData) {
            $user = $users->where('id', $item['user_id']);
            if ($user) {
                $item['user'] = $user->first()['email'];
            }

            $dialedUser = $dialedUsers->where('id', $item['dialed_user_id']);
            if ($dialedUser) {
                $item['dialed_user'] = $dialedUser->first()['email'];
            }

            $startTime = new DateTime($item['call_start_time']);
            $endTime = new DateTime($item['call_end_time']);
            $item['duration'] = $endTime->getTimestamp() - $startTime->getTimestamp();

            $userOperator = $operatorsData->filter(function ($operator) use ($item) {
                return in_array($item['user_id'], $operator['users']);
            });
            $dialedOperator = $operatorsData->filter(function ($operator) use ($item) {
                return in_array($item['dialed_user_id'], $operator['users']);
            });
            if ($userOperator->isNotEmpty() && $dialedOperator->isNotEmpty()) {
                if ($userOperator->first()['operator_id'] == $dialedOperator->first()['operator_id']) {
                    $item['call_cost'] = $item['duration'] * $userOperator->first()['prices']['internal_price'];
                } else {
                    $item['call_cost'] = ceil($item['duration'] / 60) * $userOperator->first()['prices']['external_price'];
                }
            }
            return $item;
        });
        return $calls;
    }

    private function getCallsFromDb(): Collection
    {
        $call = new Call();
        return collect($call->all());
    }

    private function getUsersFromCalls(Collection $calls): array
    {
        $userIds = $calls->pluck('user_id')->toArray();
        $dialedUserIds = $calls->pluck('dialed_user_id')->toArray();

        $user = new User();
        $users = collect($user->find($userIds));
        $dialedUsers = collect($user->find($dialedUserIds));
        return [
            'users' => $users,
            'dialedUsers' => $dialedUsers
        ];
    }

    private function getOperatorsWithListOfUsers(array $users): Collection
    {
        $userIds = $users['users']->pluck('id')->toArray();
        $dialedUserIds = $users['dialedUsers']->pluck('id')->toArray();
        $userStatements = new UserStatements();
        return collect($userStatements->getDataByUserIds(array_merge($userIds, $dialedUserIds)));
    }

    private function getOperatorsDataWithPrices(Collection $userStatementsData)
    {
        $groupedData = $userStatementsData->groupBy('operator_id')->map(function ($item) {
            return ['users' => collect($item)->pluck('user_id')->toArray()];
        })->toArray();

        $operator = new Operator();
        $operatorsDataWithPrices = collect($operator->find($userStatementsData->pluck('operator_id')->toArray()));

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
