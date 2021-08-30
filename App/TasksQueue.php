<?php

class TasksQueue
{
    public static function addTask(string $name, string $task, array $params)
    {

        $taskMeta = explode('::', $task);

        $taskClassExist = class_exists($taskMeta[0]);
        $taskMethodExist = method_exists($taskMeta[0], $taskMeta[1]);

        if (!$taskClassExist || !$taskMethodExist) {
            return false;
        }

        return Db::insert('tasks_queue', [
            'name'      => $name,
            'task'      => $task,
            'params'    => json_encode($params),
            'created_at' => Db::expr('NOW()'),
        ]);
    }

    public static function getById(int $taskId)
    {
        $query = "SELECT * FROM tasks_queue WHERE id = $taskId";
        return Db::fetchRow($query);
    }

    public static function getTaskList()
    {
        $query = "SELECT * FROM tasks_queue ORDER BY created_at DESC";
        return Db::fetchAll($query);
    }

    public static function setStatus(int $taskId, string $status)
    {
        $availableStatus = [
            'new',
            'in_process',
            'done',
        ];

        if (!in_array($status, $availableStatus)) {
            die("Проблемы со статусом" . $status);
        }

       return Db::update('tasks_queue', [
            'status' => $status,
        ], 'id = ' . $taskId);
    }
    

    public static function run($id)
    {
        $task = static::getById($id);

        if (empty($task)) {
            return false;
        }

        $taskAction = $task['task'];
        $taskAction = explode('::', $taskAction);


        $taskClassExist = class_exists($taskAction[0]);
        $taskMethodExist = method_exists($taskAction[0], $taskAction[1]);

        if (!$taskClassExist || !$taskMethodExist) {
            return false;
        }
        $taskParams = json_decode($task['params'], true);
        static::setStatus($id, 'in_process');

        call_user_func($taskAction, $taskParams);
        static::setStatus($id, 'done');

    }
}