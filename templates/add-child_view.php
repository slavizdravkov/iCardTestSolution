<?php /** $templateData \Data\TemplatesViewData */ ?>

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
    <?php if($templateData->getError()): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong><?= $templateData->getError(); ?></strong> <a href="#" class="alert-link">Направете корекции</a> и регистрирайте отново.
        </div>
    <?php endif; ?>

    <div class="container body-content span=8 offset=2">
        <div class="well">
            <form class="form-horizontal" method="post" action="#">
                <fieldset>
                    <legend>Регистрация</legend>

                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Име</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="name" placeholder="Име" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="surName" class="col-sm-4 control-label">Презиме</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="surName" placeholder="Презиме" name="surName">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="lastName" class="col-sm-4 control-label">Фамилия</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lastName" placeholder="Фамилия" name="lastName">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="egn" class="col-sm-4 control-label">ЕГН</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="egn" placeholder="ЕГН" name="egn">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="groupId" class="col-sm-4 control-label">Група</label>
                        <?php if ($templateData->getGroups()->current() === null): ?>
                            <div class="col-sm-4">
                                <select class="form-control" id="select" name="groupId">
                                    <option>
                                        Няма свободни места в групите
                                    </option>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="col-sm-4">
                                <select class="form-control" id="select" name="groupId">
                                    <?php foreach ($templateData->getGroups() as $group): ?>
                                        <option value="<?=$group->getId();?>">
                                            <?=$group->getName();?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="reset" class="btn btn-default">Отказ</button>
                            <button type="submit" class="btn btn-primary" name="register">Регистрирай</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>
