<?php

namespace App\Data\Import;


use App\Controller\AbstractController;
use App\Db\Db;
use App\Data\Import;
use App\Http\Request;
use App\Http\Response;
use App\Data\TasksQueue;

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

    public function upload( TasksQueue $queue, Db $db, ImportRepository $importRepository, Request $request)
    {
//        $file = $_FILES['import_file'] ?? null;
//
//        if (is_null($file) || empty($file['name'])) {
//            die('не загружен файл для импорта');
//        }
//
//        $uploadDir = APP_UPLOAD_DIR . '/import';
//
//        if(!file_exists($uploadDir)) {
//            mkdir ($uploadDir);
//        }
//
//        $importFilename = 'i_' . time() . $file['name'];
//
//        move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $importFilename);
//
//
////$filename = 'i_1630298545import.csv';
//        $filePath = APP_UPLOAD_DIR . '/import/' . $importFilename;


        $fieldsArr = $this->filterFieldsArr($_POST);

        $importFilename = $this->getFilePathFromPost($request);
        if (file_exists($importFilename)) {
            $taskName = 'Импорт файла ' . $importFilename;
            $task = Import::class . '::productsFromFileTask';
            $taskParams =  [
                'filename' => $importFilename,
                'fields' => $fieldsArr,
            ];

            $queue->addTask($taskName, $task, $taskParams);
        }

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
        $nameFieldsFile = $importRepository->getNames($columnFile);

        $columnTable = $db->getColumnNamesArr('products');


        return $this->render('import/parsing.tpl',[
            'fieldsFile' => $nameFieldsFile,
            'columnTable' => $columnTable,
            'filePath' => $filePath,
            ]
        );
    }

    public function getFilePathFromPost($request)
    {
        $filePathLong = $request->getStrFromPost('filePath');
        $filePath =   substr($filePathLong, strripos($filePathLong, '/') + 1);

        return $filePath;
    }

    public function filterFieldsArr($arr)
    {
        $arrExceptions = [
            'filePath'
        ];
        $result = [];
        foreach ($arr as $key => $value)
        {
            $isExceptions = false;
            foreach ($arrExceptions as  $value_e) {
                if ($key == $value_e) {
                    $isExceptions = true;
                    break;
                }
            }
            if ($isExceptions) {
                continue;
            }
            $result[$key] = $value;
        }
        return $result;
    }
}