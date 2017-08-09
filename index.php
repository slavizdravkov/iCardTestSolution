<?php
require_once 'app.php';

$templateData = $childService->getIndexViewData();

if (isset($_SESSION['error'])){
    $templateData->setError($_SESSION['error']);
    unset($_SESSION['error']);
}

if (isset($_GET['id'])){
    if (isset($_POST['missing'])){
        try{
            $childService->changeToMissing(
                $_POST['missingReason'],
                $_POST['missingTo'],
                $_GET['id']);

        }catch (Exception $e){
            $_SESSION['error'] = $e->getMessage();
        }
    }
    else{
        try{
            $childService->changeToPresent($_GET['id']);
        } catch (Exception $e){
            $_SESSION['error'] = $e->getMessage();
        }
    }
    header("Location: index.php");
    exit;

}

$childData = $childService->findAllAccepted();

if (isset($_POST['filter'])){
    switch ($_POST['filterName']){
        case 'name':
            $childData = $childService->findByName($_POST['filterString']);
            break;

        case 'waiting':
            $childData = $childService->findAllWaiting();
            break;

        case 'missing':
            $childData = $childService->findByMissingNow();
            break;

        case 'admissionDate':
            $childData = $childService->findByAdmissionDate($_POST['inputDate']);
            break;

        case 'dismissionDate':
            $childData = $childService->findByDismissionDate($_POST['inputDate']);
            break;

        case 'group':
            $childData = $childService->findByGroup($_POST['groupName']);
            break;

        default:
            $childData = $childService->findAllAccepted();
            break;
    }
}

$app->loadTemplate('index_view', $templateData, $childData);
