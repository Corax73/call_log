<?php

namespace Models;

/**
 * @property string $table
 */
class Operator extends AbstractModel
{
    public string $title;
    public int $internal_price;
    public int $external_price;
    protected string $table = 'operators';
    protected array $fillable = [
        'title',
        'internal_price',
        'external_price'
    ];
    protected array $guarded = [];

    /**
     * Save operator data.
     * @param string $title
     * @param int $internal_price
     * @param int $external_price
     * @return bool
     */
    public function save(string $title, int $internal_price, int $external_price): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:title, :internal_price, :external_price, :now)';
                $params = [
                    ':title' => $title,
                    ':internal_price' => $internal_price,
                    ':external_price' => $external_price,
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
     * Receives an array to fill the properties, calls the validation method, and if successful, fills the model.
     * @param array <string, mixed> $data
     * @return bool
     */
    public function fill(array $data): bool
    {
        $resp = false;
        $validDate = $this->validate($data);
        if ($validDate) {
            $this->title = $validDate['title'];
            $this->internal_price = $validDate['internal_price'];
            $this->external_price = $validDate['external_price'];
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
        if (!empty($this->title) && $this->internal_price && $this->external_price) {
            $resp = $this->save($this->title, $this->internal_price, $this->external_price);
        }
        return $resp;
    }

    /**
     * In the incoming array checks for the presence of keys for model properties and values, and if successful, returns a data array.
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function validate(array $data): array
    {
        $resp = [];
        if (isset($data['title']) && isset($data['internal_price']) && isset($data['external_price'])) {
            if (trim($data['title']) && intval($data['internal_price']) >= 0 && intval($data['external_price']) >= 0) {
                $resp['title'] = trim($data['title']);
                $resp['internal_price'] = intval(trim($data['internal_price']));
                $resp['external_price'] = intval(trim($data['external_price']));
            }
        }
        return $resp;
    }
}
