<?php

namespace App\Import;

use App\Import;
use App\Renderer;
use App\Response;
use App\Router\Route;
use App\TasksQueue;

class ImportController
{
    /**
     * @var Route
     */
    private Route $params;

    public function __construct(Route $params)
    {
        $this->params = $params;
    }

    public function index()
    {
        Renderer::getSmarty()->display('import/index.tpl');
    }

    public function upload(Response $response, TasksQueue $queue)
    {
        $file = $_FILES['import_file'] ?? null;

        if (is_null($file) || empty($file['name'])) {
            die('не загружен файл для импорта');
        }

        $uploadDir = APP_UPLOAD_DIR . '/import';

        if(!file_exists($uploadDir)) {
            mkdir ($uploadDir);
        }

        $importFilename = 'i_' . time() . $file['name'];

        move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $importFilename);


//$filename = 'i_1630298545import.csv';
        $filePath = APP_UPLOAD_DIR . '/import/' . $importFilename;

        $taskName = 'Импорт файла ' . $importFilename;
        $task = Import::class . '::productsFromFileTask';
        $taskParams =  [
            'filename' => $importFilename
        ];

        $queue->addTask($taskName, $task, $taskParams);
        $response->redirect('/queue/list');
    }
}