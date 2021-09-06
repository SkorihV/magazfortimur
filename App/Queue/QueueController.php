<?php

namespace App\Queue;

use App\Controller\AbstractController;
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

//        $smarty = Renderer::getSmarty();
//        $smarty->assign('tasks_queue', $tasks);
//        $smarty->display('queue/list.tpl');

        return $this->render('queue/list.tpl', [
            "tasks_queue" => $tasks
        ]);
    }

    public function run(Request $request, TasksQueue $tasksQueue )
    {
        $id = $request->getIntFromGet('id');

        $result = $tasksQueue->runById($id);
        $tasks = $tasksQueue->getTaskList();

        return $this->render('queue/list.tpl', [
            "tasks_queue" => $tasks
        ]);

    }
}