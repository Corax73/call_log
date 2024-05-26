<?php

namespace Controllers;

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
        if (isset($_POST['entity']) && !empty($_POST['entity'])) {
            if ($this->checkEntityExist($_POST['entity'])) {
                if ($this->requestExecute()) {
                    $resp = ['result' => true];
                } else {
                    $resp = ['errors' => 'check the entered data'];
                }
            } else {
                $resp = ['errors' => 'check the entered data'];
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
            if ($key != 'entity') {
                $data[$key] = $value;
            }
        }
        $filled = false;
        if ($data) {
            $filled = $entity->fill($data);
        }
        if ($filled) {
            $resp = $entity->saveByFill();
        }
        return $resp;
    }
}
