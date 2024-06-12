<?php

namespace Controllers;

use Repositories\StatisticsRepository;

/**
 * @property User $user
 */
class FormController
{
    /**
     * Checks post parameters, causes request processing.
     * @return array<string, mixed>
     */
    public function checkPost(): array
    {
        $resp = [];
        if (isset($_POST['form'])) {
            $errors = [
                'errors' => [
                    $_POST['form'] => [
                        'entered_data' => $_POST,
                        'error' => 'check the entered data'
                    ]
                ]
            ];
        }
        if (isset($_POST['entity']) && !empty($_POST['entity'])) {
            if ($this->checkEntityExist($_POST['entity'])) {
                if ($this->requestExecute()) {
                    $resp = ['result' => [$_POST['form'] => true]];
                } else {
                    $resp = $errors;
                }
            } else {
                $resp = $errors;
            }
        }
        return $resp;
    }

    /**
     * Checks the existence of an entity.
     * @param string $target
     * @return bool
     */
    private function checkEntityExist(string $target): bool
    {
        $resp = false;
        $className = 'Models\\' . ucfirst($target);
        if (class_exists($className)) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * Passes the request parameters to the entity, and if it is successfully filled, saves it.
     * @return bool
     */
    private function requestExecute(): bool
    {
        $resp = false;
        $className = 'Models\\' . ucfirst($_POST['entity']);
        $entity = new $className();
        $data = [];
        foreach ($_POST as $key => $value) {
            if ($key != 'entity' && $key != 'update') {
                $data[$key] = $value;
            }
        }
        $filled = false;
        if ($data) {
            $filled = $entity->fill($data);
        }
        if ($filled) {
            if (isset($_POST['update']) && $_POST['update'] == 1) {
                $resp = $entity->update();
            } else {
                $resp = $entity->saveByFill();
            }
        }
        return $resp;
    }

    /**
     * Returns data for statistics.
     * @return array
     */
    public function getStatistics(): array
    {
        if (isset($_POST['user_id']) && $_POST['user_id']) {
            $rep = new StatisticsRepository();
            $resp = $rep->getUserStatistics($_POST['user_id']);
            if (!$resp) {
                $resp = [
                    'errors' => [
                        $_POST['form'] => [
                            'entered_data' => $_POST,
                            'error' => 'There is no call data for this user'
                        ]
                    ]
                ];
            }
            return $resp;
        }
    }
}
