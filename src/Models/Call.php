<?php

namespace Models;

/**
 * @property string $table
 */
class Call extends AbstractModel
{
    protected string $table = 'calls';
    protected array $fillable = [
        'phone_id',
        'dialed_phone_id',
        'call_start_time',
        'call_end_time'
    ];
    protected array $guarded = [];

    /**
     * Save call data.
     * @param int $phone_id
     * @param int $dialed_phone_id
     * @param string $call_start_time
     * @param string $call_end_time
     * @return bool
     */
    public function save(int $phone_id, int $dialed_phone_id, string $call_start_time, string $call_end_time): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:phone_id, :dialed_phone_id, :call_start_time, :call_end_time, :now)';
                $params = [
                    ':phone_id' => $phone_id,
                    ':dialed_phone_id' => $dialed_phone_id,
                    ':call_start_time' => $call_start_time,
                    ':call_end_time' => $call_end_time,
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
}
