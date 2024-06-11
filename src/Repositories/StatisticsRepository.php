<?php

namespace Repositories;

use Models\PhoneNumber;
class StatisticsRepository
{
    public function getUserStatistics(int $user_id): array
    {
        $resp = [];
        $phone = new PhoneNumber();
        $phoneData = $phone->getPhoneNumber($user_id);
        if (isset($phoneData['id']) && $phoneData['id']) {
            $rep = new CallsRepository();
            $resp = $rep->getCallWithCalculatedData(100, 0, 'phone_id', $phoneData['id'])->toArray();

        }
        return $resp;
    }
}
