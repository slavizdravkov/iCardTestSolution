<?php
require_once 'app.php';

$templateData = $childService->getAddChildViewData();

if (isset($_POST['register'])) {
    try {
        $childService->addChild(
            $_POST['name'],
            $_POST['surName'],
            $_POST['lastName'],
            $_POST['egn'],
            $_POST['groupId']
        );
    } catch (Exception $e) {
        $templateData->setError($e->getMessage());
    }

}

$app->loadTemplate('add-child_view', $templateData);