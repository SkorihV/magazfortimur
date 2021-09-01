<?php

namespace App\Queue;

use App\Renderer;
use App\Request;
use App\Response;
use App\TasksQueue;

class QueueController
{

    /**
     * @var array
     */
    private array $params;

    public function __construct(array $params)
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