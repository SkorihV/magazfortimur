<?php

$id = Request::getIntFromGet('id');

$result = TasksQueue::runById($id);

Response::redirect('/queue/list');
