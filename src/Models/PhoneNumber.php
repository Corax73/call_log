<?php

namespace Models;

use PDO;

/**
 * @property string $table
 */
class PhoneNumber extends AbstractModel
{
    protected string $table = 'phone_numbers';
    protected array $fillable = [
        'number',
        'user_id'
    ];
    protected array $guarded = [];

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
}
