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
    public function checkPost(): void
    {
        if (isset($_POST['entity']) && !empty($_POST['entity'])) {
            if ($this->checkEntityExist($_POST['entity'])) {
                $this->requestExecute();
            }
        }
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

    private function requestExecute()
    {
        $className = 'Models\\' . ucfirst($_POST['entity']);
        $entity = new $className();
        $data = [];
        foreach ($_POST as $key => $value) {
            if ($key != 'entity') {
                $data[$key] = $value;
            }
        }
        $entity->fill($data);
        dump($entity);
    }
}
