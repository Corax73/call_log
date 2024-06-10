<?php

namespace Repositories;

use Models\Connect;
use Models\PhoneNumber;
use PDO;

class StatisticsRepository
{
    public function getUserStatistics(int $user_id): array
    {
        $resp = [];
        $phone = new PhoneNumber();
        $phoneData = $phone->getPhoneNumber($user_id);
        if (isset($phoneData[0]['id']) && $phoneData[0]['id']) {
            $query = 'SELECT COUNT(phone_id) as quantity FROM `calls` WHERE `phone_id` = :phone_id';
            $params = [
                ':phone_id' => $phoneData[0]['id']
            ];
            $conn = new Connect();
            $stmt = $conn->connect(PATH_CONF)->prepare($query);
            $stmt->execute($params);
            $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $resp[0];
    }
}
