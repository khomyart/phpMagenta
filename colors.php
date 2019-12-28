<?php
header("Content-Type: text/html; charset=UTF-8");

include './imports.php';
include './templates/header.php';
include './templates/navigation.php';

$searchValue = '';

if (isset($_REQUEST['isSearch']) && ($_REQUEST['isSearch'] == 'Y')) {
    $searchValue = $_REQUEST['search'];
}

$listOfColors = getListOfColors($searchValue);

if ($_GET['newColorSave']) {
    $params = [
        'color' => $_GET['color'],
        'article' => $_GET['article'],
        'description' => $_GET['description'],
        'textColor' => $_GET['textColor'],
    ];
    editColorUnit('insert', $params);

    header ('Location: colors.php');
}

if ($_GET['existColorRemove']) {
    $params = [
        'id' => $_GET['existColorRemove'],
    ];
    editColorUnit('remove', $params);

    header ('Location: colors.php');
}

if ($_GET['existColorSave']) {
    $params = [
        'color' => $_GET['existColorFieldEdit'],
        'article' => $_GET['existColorArticleFieldEdit'],
        'description' => $_GET['existColorDescriptionFieldEdit'],
        'textColor' => $_GET['existTextColorFieldEdit'],
        'id' => $_GET['existColorSave'],
    ];
    editColorUnit('update', $params);

    header ('Location: colors.php');
}

if ($_GET['cancel']) {
    header ('Location: colors.php');
}
?>

<link href="css/style_color.css" rel="stylesheet" />

<div class="container">

    <div class="row">
        <div class="col">
            <br />

            <form class="form-inline d-flex justify-content-between" action="colors.php" method="get">
                <div>
                    <input type="hidden" name="isSearch" value="Y">
                    <div class="form-group">
                        <label for="search" class="sr-only">Текст для пошуку</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            id="search"
                            placeholder="Текст для пошуку"
                            value="<?= $searchValue ?>">
                        <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Пошук</button>
                    </div>
                </div>
            </form>
            <form class="float-right" style="margin-top: -37px;" action="" method="get">
                <div>
                    <button type="submit" class="btn btn-primary" name="newColor" value="create">
                        Додати колір
                    </button>
                </div>
            </form>

            <br />
            <form action="" method="get">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="row" width="10%">№</th>
                        <th scope="col" width="20%">Колір</th>
                        <th scope="col" width="20%">Артикль</th>
                        <th scope="col" width="20%">Опис</th>
                        <th scope="col" width="20%">Колір тексту</th>
                        <th scope="col" width="10%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($_GET['newColor']) { ?>
                        <tr>
                            <th scope="row"> # </th>
                            <td>
                                <input name="color" class="form-control" style="text-align: center;">
                            </td>
                            <td>
                                <input name="article" class="form-control" style="text-align: center;">
                            </td>
                            <td>
                                <input name="description" class="form-control" style="text-align: center;">
                            </td>
                            <td>
                                <input list="textColors" name="textColor" class="form-control" style="text-align: center;">
                                <datalist id="textColors">
                                    <option value="Black">
                                    <option value="White">
                                </datalist>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle"
                                            type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                    >
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button type="submit" class="dropdown-item" name="newColorSave" value="submit">
                                            Зберегти
                                        </button>
                                        <button type="submit" class="dropdown-item" name="cancel" value="submit">
                                            Відмінити
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    $i = 1;
                    foreach ($listOfColors as $color) { 
                        if ($color['id'] == $_GET['existColorEdit']) { ?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td style="background-color: <?= $color['color'] ?>;
                                color: <?= $color['textColor'] ?>;
                                font-weight: bolder;"
                            >
                                <input name="existColorFieldEdit" class="form-control" value="<?= $color['color'] ?>" style="text-align: center;">
                            </td>
                            <td>
                                <input name="existColorArticleFieldEdit" class="form-control" value="<?= $color['article'] ?>" style="text-align: center;">
                            </td>
                            <td>
                                <input name="existColorDescriptionFieldEdit" class="form-control" value="<?= $color['description'] ?>" style="text-align: center;">
                            </td>
                            <td>
                                <input list="textColors" class="form-control" name="existTextColorFieldEdit" style="text-align: center;" style="text-align: center;" value="<?= $color['textColor'] ?>">
                                <datalist id="textColors">
                                    <option value="Black">
                                    <option value="White">
                                </datalist>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle"
                                            type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                    >
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button type="submit" class="dropdown-item" name="existColorSave" value="<?= $color['id'] ?>">
                                            Зберегти
                                        </button>
                                        <button type="submit" class="dropdown-item" name="cancel" value="submit">
                                            Відмінити
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php 
                        } else {?>
                        <tr>
                            <th scope="row"><?= $i ?></th>
                            <td style="background-color: <?= $color['color'] ?>;
                                color: <?= $color['textColor'] ?>;
                                font-weight: bolder;"
                            >
                                <?= $color['color'] ?>
                            </td>
                            <td><?= $color['article'] ?></td>
                            <td><?= $color['description'] ?></td>
                            <td><?= $color['textColor'] ?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle"
                                            type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                    >
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button type="submit" class="dropdown-item" name="existColorEdit" value="<?= $color['id'] ?>">
                                            Редагувати
                                        </button>
                                        <button type="submit" class="dropdown-item" name="existColorRemove" value="<?= $color['id'] ?>">
                                            Видалити
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                        $i++;
                    } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<?php include './templates/footer.php'; ?>
