<?php

namespace App\Queue;

use App\Controller\AbstractController;
use App\Db\Db;
use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;
use App\TasksQueue;

class QueueController extends AbstractController
{

//    /**
//     * @var Route
//     */
//    private Route $params;

    public function __construct()
    {
   //     $this->params = $params;
    }

    public function list(TasksQueue $tasksQueue )
    {
        $tasks = $tasksQueue->getTaskList();

        return $this->render('queue/list.tpl', [
            "tasks_queue" => $tasks
        ]);
    }

    public function run(Request $request, TasksQueue $tasksQueue )
    {
        $id = $request->getIntFromGet('id');

        $tasksQueue->runById($id);
        $tasks = $tasksQueue->getTaskList();

        return $this->render('queue/list.tpl', [
            "tasks_queue" => $tasks
        ]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param Db $db
     */
    public function delete(Request $request, Response $response, Db $db)
    {
        $id = $request->getIntFromGet('id');
        $fileName = $db->getFieldValueSelectedOne("tasks_queue", "id = $id", "name");
        if (!is_null($fileName)) {
            $fileName = str_replace("Импорт файла ", "", $fileName['name']);
        }

        $path = APP_UPLOAD_DIR .'/import/'. $fileName;
        unlink($path);
        $db->delete('tasks_queue', "id = $id");
        $response->redirect('/queue/list');

    }
}