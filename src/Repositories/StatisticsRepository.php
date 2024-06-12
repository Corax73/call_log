<?php

namespace Repositories;

use Illuminate\Support\Arr;
use Models\PhoneNumber;

class StatisticsRepository
{
    /**
     * Returns data for user statistics.
     * @param int $user_id
     * @return array<string, int|string>
     */
    public function getUserStatistics(int $user_id): array
    {
        $resp = [];
        $phone = new PhoneNumber();
        $phoneData = $phone->getPhoneNumber($user_id);
        if (isset($phoneData['id']) && $phoneData['id']) {
            $rep = new CallsRepository();
            $data = $rep->getCallWithCalculatedData(100, 0, 'phone_id', intval($phoneData['id']));
            if ($data->isNotEmpty() && Arr::has($data, ['0.user', '0.duration', '0.call_cost'])) {
                $resp['user_email'] = $data->first()['user'];
                $resp['quantity'] = $data->count();
                $resp['total_duration'] = $data->sum('duration');
                $resp['total_cost'] = $data->sum('call_cost');
            }
        }
        return $resp;
    }
}
