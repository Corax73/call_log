<?php

namespace Models;

/**
 * @property string $table
 */
class Operator extends AbstractModel
{
    readonly string $title;
    readonly int $internal_price;
    readonly int $external_price;
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

    public function fill(array $data)
    {
        $this->title = $data['title'];
        $this->internal_price = $data['internal_price'];
        $this->external_price = $data['external_price'];
    }
}
