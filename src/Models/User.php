<?php

namespace Models;

use PDO;

/**
 * @property string $table
 */
class User extends AbstractModel
{
    protected string $table = 'users';
    protected array $fillable = [
        'email',
        'password'
    ];
    protected array $guarded = [
        'password'
    ];

    /**
     * Save user data.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function save(string $email, string $password): bool
    {
        $resp = false;
        $strFields = implode(', ', $this->fillable);
        if ($strFields) {
            try {
                $query = 'INSERT INTO `' . $this->table . '` (' . $strFields . ', created_at) VALUES (:email, :password, :now)';

                $password = password_hash($password, PASSWORD_DEFAULT);

                $params = [
                    ':email' => $email,
                    ':password' => $password,
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
     * User authentication check.
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function authUser(string $email, string $password): bool
    {
        $resp = false;
        $query = "SELECT * FROM `users` WHERE email = :email";
        $params = [
            ':email' => $email
        ];
        $stmt = $this->connect->connect(PATH_CONF)->prepare($query);
        $stmt->execute($params);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($row) == 1) {
            if (password_verify($password, $row[0]['password'])) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * completes user authentication
     * @return void
     */
    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        unset($_SESSION['email']);
        header("Location: /");
        exit();
    }
}
