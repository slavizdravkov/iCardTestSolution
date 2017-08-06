<?php
require_once 'app.php';

$data = $childService->findAllAccepted();

$app->loadTemplate('index_view', $data);
