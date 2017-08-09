<?php
require_once 'app.php';

$templateData = new \Data\TemplatesViewData();

if (isset($_SESSION['form'])) {
    $templateData->setError($_SESSION['error']);
    $templateData->setFormData($_SESSION['form']);
    unset($_SESSION['form']);
}

if (isset($_POST['add'])){
    try{
        $groupService->addGroup(
            $_POST['groupName'],
            $_POST['teacherName']
        );
    }catch (Exception $e){
        $_SESSION['error'] = $e->getMessage();
        $_SESSION['form'] = $_POST;
        header("Location: add-group.php");
        exit;
    }
}
$app->loadTemplate('add-group_view', $templateData);