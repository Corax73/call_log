<?php

namespace Controllers;

/**
 * @property User $user
 */
class FormController
{
    /**
     * @return void
     */
    public function checkPost(): array
    {
        $res = false;
        $errors = ['errors' => 'something'];
        if (isset($_POST['entity']) && !empty($_POST['entity'])) {
            if ($this->checkEntityExist($_POST['entity'])) {
                $res = $this->requestExecute();
            }
        }

        return $res ? ['result' => true] : $errors;
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
        $filled = $entity->fill($data);
        if($filled) {
            $resp = $entity->saveByFill();
        }
        return $resp;
    }
}
