<?php

namespace Models;

/**
 * @property string $table
 */
class Call extends AbstractModel
{
    protected string $table = 'calls';
    protected array $fillable = [
        'user_id',
        'dialed_user_id',
        'call_start_time',
        'call_end_time'
    ];
    protected array $guarded = [];

    /**
     * Save call data.
     * @param int $user_id
     * @param int $dialed_user_id
     * @param string $call_start_time
     * @param string $call_end_time
     * @return bool
     */
    public function save(int $user_id, int $dialed_user_id, string $call_start_time, string $call_end_time): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ') VALUES (:user_id, :dialed_user_id, :call_start_time, :call_end_time)';
                $params = [
                    ':user_id' => $user_id,
                    ':dialed_user_id' => $dialed_user_id,
                    ':call_start_time' => $call_start_time,
                    ':call_end_time' => $call_end_time
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
}
