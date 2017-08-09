<?php
require_once 'app.php';

$templateData = $childService->getAddChildViewData();

if (isset($_SESSION['form'])) {
    $templateData->setError($_SESSION['error']);
    $templateData->setFormData($_SESSION['form']);
    unset($_SESSION['form']);
}

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
        $_SESSION['error'] = $e->getMessage();
        $_SESSION['form'] = $_POST;
        header("Location: add-child.php");
        exit;
    }
    header("Location: add-child.php");
    exit;
}

$app->loadTemplate('add-child_view', $templateData);