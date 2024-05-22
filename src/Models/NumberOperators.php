<?php

namespace Models;

use PDO;

/**
 * @property string $table
 */
class NumberOperators extends AbstractModel
{
    protected string $table = 'number_operators';
    protected array $fillable = [
        'number_id',
        'operator_id'
    ];
    protected array $guarded = [];

    /**
     * Save relationship between numbers and operators.
     * @param int $number_id
     * @param int $operator_id
     * @return bool
     */
    public function save(int $number_id, int $operator_id): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:number_id, :operator_id, :now)';
                $params = [
                    ':number_id' => $number_id,
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

    /**
     * Returns model data by identifier or array of identifiers.
     * @param int|array<int, int> $number_id
     * @return array<string, string|int>
     */
    public function getDataByNumberIds(int|array $number_id): array | bool
    {
        if (is_array($number_id)) {
            $params = $number_id;
            $placeholders = str_repeat('?, ',  count($number_id) - 1) . '?';
            $query = "SELECT id, " . implode(', ', array_diff($this->fillable, $this->guarded)) . ",created_at FROM `$this->table` WHERE `number_id` IN ($placeholders)";
        } else {
            $query = 'SELECT id, ' . implode(', ', array_diff($this->fillable, $this->guarded)) . ',created_at FROM `' . $this->table . '` WHERE `number_id` = :number_id';
            $params = [
                ':number_id' => $number_id
            ];
        }
        $query .= ' ORDER BY `id` DESC';
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute($params);
        $resp = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resp ? $resp : false;
    }
}
