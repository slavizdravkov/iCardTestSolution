<?php /** @var $data \Data\ChildViewData[] */?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<body>
    <div class="container body-content span=8 offset=2">
        <div class="well">
            <form class="form-horizontal" method="post" action="#">
                <fieldset>
                    <legend>Филтър</legend>

                    <div class="form-group">
                        <label for="filterName" class="col-sm-4 control-label">Филтрирай по:</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="select" name="filterName">
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

                    <div class="form-group">
                        <label for="key" class="col-sm-4 control-label">Ключ</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="key" placeholder="Ключ" name="key">
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
                <th>Период на отсъствие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $child): ?>
                <tr>
                    <td><?=$child->getName(); ?></td>
                    <td><?=$child->getSurName(); ?></td>
                    <td><?=$child->getLastName(); ?></td>
                    <td><?=$child->getEgn(); ?></td>
                    <td><?=$child->getGroupName(); ?></td>
                    <td><?=$child->getAge(); ?></td>
                    <td><?=$child->getTeacherName(); ?></td>
                    <td><?=$child->getAdmissionDate(); ?></td>
                    <td><?=$child->getisPresent(); ?></td>
                    <td><?=$child->getMissingReason(); ?></td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</body>
</html>
