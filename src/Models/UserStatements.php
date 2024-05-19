<?php

namespace Models;

use PDO;

/**
 * @property string $table
 */
class UserStatements extends AbstractModel
{
    protected string $table = 'user-statements';
    protected array $fillable = [
        'user_id',
        'operator_id'
    ];
    protected array $guarded = [];

    /**
     * Save relationship between users and operators.
     * @param int $user_id
     * @param int $operator_id
     * @return bool
     */
    public function save(int $user_id, int $operator_id): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:user_id, :operator_id, :now)';
                $params = [
                    ':user_id' => $user_id,
                    ':operator_id' => $operator_id,
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
