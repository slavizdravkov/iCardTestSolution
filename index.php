<?php
require_once 'app.php';

$data = $childService->findAllAccepted();

if (isset($_POST['filter'])){
    switch ($_POST['filterName']){
        case 'name':
            $data = $childService->findByName($_POST['key']);
            break;

        case 'waiting':
            $data = $childService->findAllWaiting();
            break;

        case 'missing':
            $data = $childService->findByMissingNow();
            break;

        case 'admissionDate':
            $data = $childService->findByAdmissionDate($_POST['key']);
            break;

        case 'dismissionDate':
            $data = $childService->findByDismissionDate($_POST['key']);
            break;

        case 'group':
            $data = $childService->findByGroup($_POST['key']);
            break;

        default:
            $data = $childService->findAllAccepted();
            break;
    }
}

$app->loadTemplate('index_view', $data);
