<?php

namespace App\Queue;

use App\Renderer;
use App\Request;
use App\Response;
use App\Router\Route;
use App\TasksQueue;

class QueueController
{

    /**
     * @var Route
     */
    private Route $params;

    public function __construct(Route $params)
    {
        $this->params = $params;
    }

    public function list()
    {
        $tasks = TasksQueue::getTaskList();

        $smarty = Renderer::getSmarty();
        $smarty->assign('tasks_queue', $tasks);
        $smarty->display('queue/list.tpl');
    }

    public function run()
    {
        $id = Request::getIntFromGet('id');

        $result = TasksQueue::runById($id);

        Response::redirect('/queue/list');

    }
}