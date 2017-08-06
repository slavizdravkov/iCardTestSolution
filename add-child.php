<?php
require_once 'app.php';

$data = $childService->getRegisterViewData();

if (isset($_POST['register'])) {
    $childService->addChild(
        $_POST['name'],
        $_POST['surName'],
        $_POST['lastName'],
        $_POST['egn'],
        $_POST['groupId']
    );
}

$app->loadTemplate('add-child_view', $data);