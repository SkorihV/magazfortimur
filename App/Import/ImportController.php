<?php

namespace App\Import;


use App\Controller\AbstractController;
use App\Db\Db;
use App\Import;
use App\TasksQueue;

class ImportController extends AbstractController
{
//    /**
//     * @var Route
//     */
//    private Route $params;

    public function __construct()
    {
//        $this->params = $params;
    }

    public function index()
    {

        //Renderer::getSmarty()->display('import/index.tpl');

        //$category = $categoryService->getList();

        return $this->render('import/index.tpl');
    }

    public function upload( TasksQueue $queue, Db $db, ImportRepository $importRepository)
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
        $tasks_queue = $queue->getTaskList();


        return $this->render('queue/list.tpl',[
        "tasks_queue" => $tasks_queue
        ]);
    }

    public function parsing( Db $db, ImportRepository $importRepository)
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
        $filePath = APP_UPLOAD_DIR . '/import/' . $importFilename;

        $columnFile = $importRepository->getFirstLineArray($filePath);
        $fieldsFile = $importRepository->getNames($columnFile);

        $columnTable = $db->getColumnNamesArr('products');


        return $this->render('import/parsing.tpl',[
            'fieldsFile' => $columnFile,
            'columnTable' => $columnTable,
                'filePath' => $filePath]
    );
    }
}