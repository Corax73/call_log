<?php

namespace Models;

use PDO;

/**
 * @property string $table
 */
class PhoneNumber extends AbstractModel
{
    protected string $table = 'phone_numbers';
    public int $number;
    public int $user_id;
    protected array $fillable = [
        'number',
        'user_id'
    ];
    protected array $guarded = [];
    protected string $unique = 'number';

    /**
     * Saves the number and link to the user.
     * @param int $number
     * @param int $user_id
     * @return bool
     */
    public function save(int $number, int $user_id): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:number, :user_id, :now)';
                $params = [
                    ':number' => $number,
                    ':user_id' => $user_id,
                    ':now' => date('Y-m-d h:i:s', time())
                ];
                $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
                $this->connect->connect(PATH_CONF)->beginTransaction();
                $resp = $stmt->execute($params);
                $this->connect->connect(PATH_CONF)->commit();
            } catch (\Exception $e) {
                if ($this->connect->connect(PATH_CONF)->inTransaction()) {
                    $this->connect->connect(PATH_CONF)->rollback();
                }
                throw $e;
            }
        }
        return $resp;
    }

    /**
     * Returns model data by identifier or array of IDs.
     * @param int|array<int, int> $user_id
     * @return array<string, string|int>
     */
    public function getDataByUserIds(int|array $user_id): array | bool
    {
        if (is_array($user_id)) {
            $params = $user_id;
            $placeholders = str_repeat('?, ',  count($user_id) - 1) . '?';
            $query = "SELECT id, " . implode(', ', array_diff($this->fillable, $this->guarded)) . ",created_at FROM `$this->table` WHERE `user_id` IN ($placeholders)";
        } else {
            $query = 'SELECT id, ' . implode(', ', array_diff($this->fillable, $this->guarded)) . ',created_at FROM `' . $this->table . '` WHERE `user_id` = :user_id';
            $params = [
                ':user_id' => $user_id
            ];
        }
        $query .= ' ORDER BY `id` DESC';
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute($params);
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resp ? $resp : false;
    }

    /**
     * Calls the save method if the instance properties are filled.
     * @return bool
     */
    public function saveByFill(): bool
    {
        $resp = false;
        if ($this->number && $this->user_id) {
            $resp = $this->save($this->number, $this->user_id);
        }
        return $resp;
    }

    /**
     * In the incoming array checks for the presence of keys for model properties and values, and if successful, returns a data array.
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function validate(array $data): array
    {
        $resp = [];
        if (isset($data['number']) && isset($data['user_id'])) {
            if (intval($data['number']) >= 0 && intval($data['user_id']) >= 0) {
                if ($this->checkUnique(intval($data['number']))) {
                    $resp['number'] = intval(trim($data['number']));
                    $resp['user_id'] = intval(trim($data['user_id']));
                }
            }
        }
        return $resp;
    }

    /**
     * Updates a record, search by user id.
     * @return bool
     */
    public function update(): bool
    {
        $resp = false;
        if ($this->number > 0 && $this->user_id > 0) {
            try {
                $query = 'UPDATE `' . $this->table . '` SET `number` = :number WHERE `user_id` = :user_id';
                $params = [
                    ':number' => $this->number,
                    ':user_id' => $this->user_id
                ];
                $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
                $this->connect->connect(PATH_CONF)->beginTransaction();
                $resp = $stmt->execute($params);
                $this->connect->connect(PATH_CONF)->commit();
            } catch (\Exception $e) {
                if ($this->connect->connect(PATH_CONF)->inTransaction()) {
                    $this->connect->connect(PATH_CONF)->rollback();
                }
                throw $e;
            }
        }
        return $resp;
    }

    /**
     * Returns the id of a phone number by its user id.
     * @param int $user_id
     * @return array<string, int|string>
     */
    public function getPhoneNumber(int $user_id): array
    {
        $resp = [];
        $query = 'SELECT id, ' . implode(', ', array_diff($this->fillable, $this->guarded)) . ',created_at FROM `' . $this->table . '` WHERE `user_id` = :user_id';
        $params = [
            ':user_id' => $user_id
        ];
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result[0])) {
            $resp = $result[0];
        }
        return $resp;
    }
}
