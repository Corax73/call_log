<?php

namespace Models;

/**
 * @property string $table
 */
class Call extends AbstractModel
{
    protected string $table = 'calls';
    public int $phone_id;
    public int $dialed_phone_id;
    public string $call_start_time;
    public string $call_end_time;
    protected array $fillable = [
        'phone_id',
        'dialed_phone_id',
        'call_start_time',
        'call_end_time'
    ];
    protected array $guarded = [];
    protected string $unique = '';

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

    /**
     * Overridden.
     * Receives an array to fill the properties, calls the validation method, and if successful, fills the model.
     * @param array <string, mixed> $data
     * @return bool
     */
    public function fill(array $data): bool
    {
        $resp = false;
        $validDate = $this->validate($data);
        if ($validDate) {
            foreach ($this->fillable as $prop) {
                $this->$prop = $validDate[$prop];
            }
            $resp = true;
        }
        return $resp;
    }

    /**
     * Calls the save method if the instance properties are filled.
     * @return bool
     */
    public function saveByFill(): bool
    {
        $resp = false;
        if ($this->phone_id && $this->dialed_phone_id && $this->call_start_time && $this->call_end_time) {
            $resp = $this->save($this->phone_id, $this->dialed_phone_id, $this->call_start_time, $this->call_end_time);
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
        if (isset($data['phone_id']) && isset($data['dialed_phone_id']) && $data['call_start_time'] && $data['call_end_time']) {
            if (intval($data['phone_id']) != intval($data['dialed_phone_id']) && strtotime($data['call_start_time']) < strtotime($data['call_end_time'])) {
                $resp['phone_id'] = intval(trim($data['phone_id']));
                $resp['dialed_phone_id'] = intval(trim($data['dialed_phone_id']));
                $resp['call_start_time'] = date('Y-m-d h:i:s', strtotime($data['call_start_time']));
                $resp['call_end_time'] = date('Y-m-d h:i:s', strtotime($data['call_end_time']));
            }
        }
        return $resp;
    }
}
