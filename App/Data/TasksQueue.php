<?php

namespace App\Data;

use App\Db\Db;

class TasksQueue
{
    public function addTask(string $name, string $task, array $params)
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

    public function getById(int $taskId)
    {
        $query = "SELECT * FROM tasks_queue WHERE id = $taskId";
        return Db::fetchRow($query);
    }

    public static function getTaskList()
    {
        $query = "SELECT * FROM tasks_queue ORDER BY created_at DESC";
        return Db::fetchAll($query);
    }

    public function setStatus(int $taskId, string $status)
    {
        $availableStatus = [
            'new',
            'in_process',
            'done',
            'error',
        ];

        if (!in_array($status, $availableStatus)) {
            die("Проблемы со статусом" . $status);
        }

       return Db::update('tasks_queue', [
            'status' => $status,
        ], 'id = ' . $taskId);
    }
    

    public function runById($id)
    {
        $task = $this->getById($id);

        return $this->run($task);

    }

    public function run(array $task): bool
    {
        $taskId = $task['id'] ?? '';
        if (empty($task) || is_null($taskId)) {
            return false;
        }

        $taskAction = $task['task'];
        $taskAction = explode('::', $taskAction);


        $taskClassExist = class_exists($taskAction[0]);
        $taskMethodExist = method_exists($taskAction[0], $taskAction[1]);

        if (!$taskClassExist || !$taskMethodExist) {
            $this->setStatus($taskId, 'error');
            return false;
        }
        $taskParams = json_decode($task['params'], true);


        $this->setStatus($taskId, 'in_process');

        $filename['filename'] = $taskParams['filename'];
        $fields = $taskParams['fields'];


        call_user_func($taskAction, $filename,  $fields);
        $this->setStatus($taskId, 'done');

        return true;
    }

    public function execute()
    {
        $query = "SELECT * FROM tasks_queue WHERE status = 'in_process' LIMIT 1";
        $inProcessTask = Db::fetchRow($query);

        if (!empty($inProcessTask)) {
            echo "in_process task found";
            return false;
        }

        $query = "SELECT * FROM tasks_queue WHERE status = 'new' ORDER BY created_at LIMIT 1";
        $newTaskProcess = Db::fetchRow($query);

        if (empty($newTaskProcess)) {
            echo "new task";
            return false;
        }
        echo "new task found";

        return $this->run($newTaskProcess);
    }
}