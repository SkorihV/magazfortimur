<?php

use App\TasksQueue;

$tasks = TasksQueue::getTaskList();

$smarty->assign('tasks_queue', $tasks);
$smarty->display('queue/list.tpl');