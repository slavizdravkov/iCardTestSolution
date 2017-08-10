<?php /** @var $childData \Data\ChildViewData[] */?>
<?php /** @var $templateData \Data\TemplatesViewData */?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker3.css">
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="js/moment.js"></script>
    <script type="text/javascript" src="js/transition.js"></script>
    <script type="text/javascript" src="js/collapse.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="js/bg.js"></script>
    <title>Home</title>
</head>

<header>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Конче Вихрогонче</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Администриране <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="add-child.php">Запиши дете в регистъра</a></li>
                            <li><a href="add-group.php">Добави група</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    <?php if($templateData->getError()): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?= $templateData->getError(); ?></strong> <a href="index.php" class="alert-link">Направете корекции</a> и изпратете отново.
        </div>
    <?php endif; ?>

    <table class="table table-striped table-hover ">
        <thead>
            <tr>
                <th>Име</th>
                <th>Презиме</th>
                <th>Фамилия</th>
                <th>ЕГН</th>
                <th>Група</th>
                <th>Възраст</th>
                <th>Имена на учителката</th>
                <th>Дата на постъпване</th>
                <th>Присъствие</th>
                <th>Причина за отсъствие</th>
                <th>До кога ще отсъства / Период на отсъствие</th>
                <th>Редактирай</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($childData as $child): ?>
                    <?php if ($child->isPresentNow()): ?>
                        <form method="post" action="index.php?id=<?= $child->getId(); ?>" class="form-horizontal">
                            <tr>
                                <td><?=$child->getName(); ?></td>
                                <td><?=$child->getSurName(); ?></td>
                                <td><?=$child->getLastName(); ?></td>
                                <td><?=$child->getEgn(); ?></td>
                                <td><?=$child->getGroupName(); ?></td>
                                <td><?=$child->getAge(); ?></td>
                                <td><?=$child->getTeacherName(); ?></td>
                                <td><?=$child->getAdmissionDate(); ?></td>
                                <td><?=$child->getPresentStatus(); ?></td>
                                <td><input class="form-control" type="text" id="inputSmall" name="missingReason"></td>
                                <td>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class=''>
                                                <div class="form-group">
                                                    <div class='input-group date datepicker-me-class' id='datetimepicker2'>
                                                        <input type='text' class="form-control" name="missingTo">
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary" name="missing">Отсъства</button>
                                </td>
                            </tr>
                        </form>
                    <?php else: ?>
                    <tr>
                        <td><?=$child->getName(); ?></td>
                        <td><?=$child->getSurName(); ?></td>
                        <td><?=$child->getLastName(); ?></td>
                        <td><?=$child->getEgn(); ?></td>
                        <td><?=$child->getGroupName(); ?></td>
                        <td><?=$child->getAge(); ?></td>
                        <td><?=$child->getTeacherName(); ?></td>
                        <td><?=$child->getAdmissionDate(); ?></td>
                        <td><?=$child->getPresentStatus(); ?></td>
                        <td><?=$child->getMissingReason(); ?></td>
                        <?php if ($child->getTeacherName()): ?>
                            <td><?=$child->getMissingPeriod(); ?></td>
                            <td>
                                <a href="index.php?id=<?= $child->getId(); ?>"><button type="button" class="btn btn-primary" name="isPresent">Присъства</button> </a>
                            </td>
                        <?php else: ?>
                            <td></td>
                            <td></td>
                        <?php endif; ?>
                    <?php endif; ?>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <div class="container body-content span=8 offset=2">
        <div class="well">
            <form class="form-horizontal" method="post" action="#">
                <fieldset>
                    <legend>Филтър</legend>

                    <div class="form-group">
                        <label for="filterName" class="col-sm-4 control-label">Филтрирай по:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="select" name="filterName">
                                <option value="selectFilter">
                                    Изберете филтър от списъка
                                </option>
                                <option value="admissionDate">
                                    Дата на постъпване
                                </option>
                                <option value="dismissionDate">
                                    Дата на отписване
                                </option>
                                <option value="name">
                                    Име
                                </option>
                                <option value="group">
                                    Група
                                </option>
                                <option value="missing">
                                    Отсъстващи в момента
                                </option>
                                <option value="waiting">
                                    Чакащи за постъпване
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="key">
                        <label for="filterString" class="col-sm-4 control-label">Ключ</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="filterString" placeholder="Ключ" name="filterString">
                        </div>
                    </div>

                    <div class="container" id="inpDate">
                        <div class="row">
                            <label for="datetimepicker1" class="col-sm-4 control-label">Изберете дата</label>
                            <div class='col-sm-4'>
                                <div class="form-group">
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type='text' class="form-control" name="inputDate">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="groups">
                        <label for="select" class="col-sm-4 control-label">Група</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="select" name="groupName">
                                <?php foreach ($templateData->getGroups() as $group): ?>
                                    <option value="<?=$group->getName();?>">
                                        <?=$group->getName();?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="reset" class="btn btn-default">Отказ</button>
                            <button type="submit" class="btn btn-primary" name="filter">Филтрирай</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>


    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                locale: 'bg'
            });
            $('.datepicker-me-class').datetimepicker({
                locale: 'bg'
            });
            //console.log($('#select option:selected'));
            hideElements();
            $('#select').on('change', function () {
                console.log($(this).val());
                switch ($(this).val()) {
                    case 'admissionDate':
                        hideElements();
                        $('#inpDate').removeAttr('style');
                        break;

                    case 'dismissionDate':
                        hideElements();
                        $('#inpDate').removeAttr('style');
                        break;

                    case 'name':
                        hideElements();
                        $('#key').removeAttr('style');
                        break;

                    case 'group':
                        hideElements();
                        $('#groups').removeAttr('style');
                        break;

                    case 'missing':
                        hideElements();
                        break;

                    case 'waiting':
                        hideElements();
                        break;

                    default: break;

                }
            });

            function hideElements() {
                $('#key').attr('style', 'display: none');
                $('#inpDate').attr('style', 'display: none');
                $('#groups').attr('style', 'display: none');
            }
        });
    </script>
</body>
</html>
