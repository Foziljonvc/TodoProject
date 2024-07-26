<?php

declare(strict_types=1);

class inspection {

    public function isApiCall(string $path)
    {
        return array_search('api', explode('/', $path));
    }

    public function isTasksCall(string $path) 
    {
        return array_search('tasks', explode('/', $path));
    }

    public function getBeforeTheLast(string $path) 
    {
        $uri = explode('/', $path);
        $check = array_search('check', $uri);

        if ($check != false) {
            return $uri[$check];
        }

        $uncheck = array_search('uncheck', $uri);

        if ($uncheck != false) {
            return $uri[$uncheck];
        }

        $delete = array_search('delete', $uri);

        if ($delete != false) {
            return true;
        }

        return false;
    }

    public function getLastOne(string $path)
    {
        $uri = explode('/', $path);
        $resource = end($uri);

        // echo $resource;

        if ($resource == 'tasks' || $resource == 'check' || $resource == 'uncheck' || $resource == 'delete') {
            // echo $resource;

            return false;

        }

        return $resource;
    }

}