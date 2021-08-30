<?php

$id = Request::getIntFromGet('id');

$result = TasksQueue::run($id);

Response::redirect('/queue/list');
