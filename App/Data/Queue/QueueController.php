<?php

namespace App\Data\Queue;

use App\Controller\AbstractController;
use App\Db\Db;
use App\Renderer\Renderer;
use App\Http\Request;
use App\Http\Response;
use App\Router\Route;
use App\Data\TasksQueue;

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

//        return $this->render('queue/list.tpl', [
//            "tasks_queue" => $tasks
//        ]);


        return $this->redirect('queue/list.tpl');
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
       // $response->setRedirectUrl('/queue/list');
        echo "<pre>";
        var_dump( $this->redirect('/queue/list'));
        echo "</pre>";

exit;
    }
}