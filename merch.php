<?php
include './imports.php';
header("Content-Type: text/html; charset=UTF-8");

$searchValue = '';
$availableColours = getListOfAvailableColors();

//echo $_GET['fileLocation'];
//var_dump($_GET);

/* Searching algorithm */
if (isset($_REQUEST['isSearch']) && ($_REQUEST['isSearch'] == 'Y')) {
    $searchValue = $_REQUEST['search'];
}

/* If pressed "cancel" - reload page and clear all $post/$get super globals */
if (isset($_GET['cancel'])) {
    header('Location: merch.php');
}

/* Activating when user press' "Save" key and perform merch type save */
if (isset($_GET['newMerchTypeSave'])) {
    $params = [
        'merchTypeName' => $_GET['newMerchTypeName'],
    ];

    insertUnit('merchType', $params);
}

/* Activating when user press' "Save" key and perform merch type save after editing it */
if (isset($_GET['MerchTypeEditSave'])) {
    $params = [
        'merchTypeName' => $_GET['MerchTypeEditName'],
        'id' => $_GET['MerchTypeEditSave'],
    ];

    updateUnit('merchType', $params);
}

/* Performs merch type delete when appropriate button has been pressed */
if (isset($_GET['MerchTypeDelete'])) {
    $params = [
        'id' => $_GET['MerchTypeDelete'],
    ];

    removeUnit('merchType', $params);
}

$targetFile = $_GET['fileLocation'];
$imgMerchUnderTypeZIndex = -1;
$addingImageInputType = '';

if ($targetFile) {
    $imgMerchUnderTypeZIndex = 4000;
    $addingImageInputType = 'hidden';
}

/* Performs merch under type creating when all fields are filled and appropriate button has been pressed */
if (isset($_GET['newMerchUnderTypeSave'])) {
    $params = [
        'merchTypeId' => $_GET['newMerchUnderType']['listOfTypes'],
        'merchUnderTypeName' => $_GET['newMerchUnderType']['header'],
        'img' => $_GET['newMerchUnderType']['img'],
        'description' => nl2br($_GET['newMerchUnderType']['desc']),
        'price' => $_GET['newMerchUnderType']['price'],
    ];

    insertUnit('merchUnderType', $params);

    $lastAddedMerchUnderTypeQuery = 'SELECT id FROM `merch_under_types` ORDER BY id DESC LIMIT 1';
    $lastAddedMerchUnderTypeId = getRow($lastAddedMerchUnderTypeQuery, []);

   foreach ($_GET['newMerchUnderTypeColours'] as $colour) {
        $addColourParams = [
            'merchUnderTypeId' => $lastAddedMerchUnderTypeId['id'],
            'colorId' => $colour,
        ];

        insertUnit('merchUnderTypeColor', $addColourParams);
    }

    $availableSizeParams = [
        'merch_under_type_id' => $lastAddedMerchUnderTypeId['id'],
        'S_a' => $_GET['newMerchUnderTypeAvailableSizes']['s_a'],
        'S_b' => $_GET['newMerchUnderTypeAvailableSizes']['s_b'],
        'M_a' => $_GET['newMerchUnderTypeAvailableSizes']['m_a'],
        'M_b' => $_GET['newMerchUnderTypeAvailableSizes']['m_b'],
        'L_a' => $_GET['newMerchUnderTypeAvailableSizes']['l_a'],
        'L_b' => $_GET['newMerchUnderTypeAvailableSizes']['l_b'],
        'XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['xl_a'],
        'XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['xl_b'],
        'XXL_a' => $_GET['newMerchUnderTypeAvailableSizes']['xxl_a'],
        'XXL_b' =>  $_GET['newMerchUnderTypeAvailableSizes']['xxl_b'],
        '3XL_a' =>  $_GET['newMerchUnderTypeAvailableSizes']['3xl_a'],
        '3XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['3xl_b'],
        '4XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['4xl_a'],
        '4XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['4xl_b'],
        '5XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['5xl_a'],
        '5XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['5xl_b'],
        ];

        foreach ($availableSizeParams as &$availableSizeParam) {
            if (empty($availableSizeParam)) {
                $availableSizeParam = NULL;
            }
        }

    insertUnit('size', $availableSizeParams);
    header('Location: merch.php');
}

/* Performs merch under type deleting when appropriate button has been pressed */
if (isset($_GET['MerchUnderTypeDelete'])) {
    $merchUnderTypeDelParam = [
        'id' => $_GET['MerchUnderTypeDelete'],
    ];

    if(removeUnit('merchUnderType', $merchUnderTypeDelParam)) {
        header('Location: merch.php');
    }
};

/* Merch types */
$positions = getListOfMerchTypes($searchValue);
/* Merch under types */
$underPositions = getListOfMerchUnderTypes($searchValue);
/* Colors for particular under types (under positions) */
$colourPacks = getListOfColourPack($searchValue);
/* Sizes for particular under types (under positions) */
$availableSizes = getListOfAvailableSizes($searchValue);

$merchTypesDisplayBlock = false;

/* If user is currently editing merch type, hide another merch types */
if ($_GET['MerchTypeEdit'] || $_GET['newMerchUnderType']) {
    $merchTypesDisplayBlock = true;
}

include './templates/header.php'; ?>

<link href="css/style_merch.css" rel="stylesheet" />

<?php include './templates/navigation.php'; ?>

<div class="container">
    <form action="./lib/upload.php" method="post" enctype="multipart/form-data" id="uploadingFormFile">

    </form>
    <div class="row">
        <div class="col">
            <br />

            <form class="form-inline d-flex justify-content-between" action="merch.php" method="get">
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
                    <button type="submit" class="btn btn-primary" name="newMerchType" value="create">
                        Додати вид товару
                    </button>
                </div>
                <div class="float-right" style="margin-top: 8px;">
                    <button class="btn btn-secondary"
                            type="submit"
                            name="newMerchUnderType"
                            value='submit'
                    >
                        Додати товар
                    </button>
                </div>
            </form>

            <br />
            <form action="" method="get">
                <?php
                if (isset($_GET['newMerchUnderType'])) {
                    unset($_GET); ?>
                    <!--MerchUnderTypeCreate-->
                    <div class="full-length-back position-relative" style="margin-top: 30px;">
                        <div class="dropdown position-absolute"
                             style="margin-top:-25px; top:40px; right: 15px;">
                            <button class="btn btn-info dropdown-toggle"
                                    type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    style="height: 40px;"
                            >
                                Опції
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item" name="newMerchUnderTypeSave"
                                        value="Submit">
                                    Зберегти
                                </button>
                                <button class="dropdown-item" name="cancel"
                                        value="Submit">
                                    Відмінити
                                </button>
                            </div>
                        </div>
                        <div style="margin-top:40px;">
                            <select class="form-control" name="newMerchUnderType[listOfTypes]">
                                <option value="">
                                    Вид товару
                                </option>
                                <?php
                                foreach ($positions as $position) { ?>
                                    <option value="<?= $position['id'] ?>">
                                        <?= $position['merch_type_name'] ?>
                                    </option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div class="input-group mt-4 col-6">
                            <div class="custom-file d-flex justify-content-between">
                                <input type="file" class="uploading-image-input" form="uploadingFormFile" name="fileToUpload" id="fileToUpload">
                                <button class="uploading-button-input" type="submit" form="uploadingFormFile" name="submit">
                                    Завантажити
                                </button>
                            </div>
                        </div>
                        <div class="info-container">
                            <div class="info-container-img d-flex flex-column justify-content-center align-items-center">
                                <img src="<?= $targetFile ?>" style="z-index: <?= $imgMerchUnderTypeZIndex ?>;" alt="">
                                <label>Посилання на зображення</label>
                                <input type="<?= $addingImageInputType ?>" class="form-control" name="newMerchUnderType[img]" style="width: 100%;" value="<?= $targetFile ?>">
                            </div>
                            <div class="info-container-text">
                                <div class="info-container-text-header d-flex flex-column justify-content-center align-items-center">
                                    <label>Заголовок</label>
                                    <h2>
                                        <input class="form-control" style="width: 350px;" name="newMerchUnderType[header]">
                                    </h2>
                                </div>
                                <div class="info-container-text-desc d-flex flex-column justify-content-center align-items-center">
                                    <label>Опис</label>
                                    <textarea class=" d-inline-block form-control" name="newMerchUnderType[desc]"
                                              style="height: 160px; width: 350px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="color-block-holder">
                            <?php
                            $i=0;
                            foreach ($availableColours as $availableColour) {?>
                                <div style="margin: 0px 25px 15px 25px;
                                            ">
                                    <input class="form-check-input color_checkbox" type="checkbox" id="<?= $i ?>"
                                           name="newMerchUnderTypeColours[<?= $i ?>]"
                                           value="<?=$availableColour['id']?>">
                                    <label class="form-check-label color_checkbox_label" for="<?= $i ?>">
                                        <div class="color-block" style="
                                                background-color: <?=$availableColour['color']?>;
                                                margin-left: 0px;" 
                                                data-toggle="tooltip" data-placement="top" 
                                                title="<?=$availableColour['description']?>">
                                            <div class="color-block-text" style="
                                                    color: <?=$availableColour['textColor']?>">
                                                    <?=$availableColour['article']?>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            <?php
                                /* Making unique id every foreach iteration to prevent checkboxes problems */
                                $i += 1;
                            } ?>
                        </div>
                        <div class="size-table-div">
                            <table class="table">
                                <thead class="thead-light">
                                <tr >
                                    <th scope="col"></th>
                                    <th scope="col">S</th>
                                    <th scope="col">M</th>
                                    <th scope="col">L</th>
                                    <th scope="col">XL</th>
                                    <th scope="col">XXL</th>
                                    <th scope="col">3XL</th>
                                    <th scope="col">4XL</th>
                                    <th scope="col">5XL</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">a (см)</th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[s_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[m_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[l_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xl_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xxl_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[3xl_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[4xl_a]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[5xl_a]"></th>
                                </tr>
                                <tr>
                                    <th scope="row">b (см)</th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[s_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[m_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[l_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xl_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xxl_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[3xl_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[4xl_b]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[5xl_b]"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="position-price">
                            <h2>
                                Ціна: <input class="form-control" type="number" name="newMerchUnderType[price]"> грн
                            </h2>
                        </div>
                    </div>
                    <div class="space-between-lots"></div>
                    <!--MerchUnderTypeCreate close-->
                <?php
                }
                if (isset($_GET['newMerchType'])) {
                    unset($_GET); ?>
                    <div class="content-header">
                        <h2>
                            <input class="text-align-center" name="newMerchTypeName">
                        </h2>
                    </div>
                    <div class="dropdown float-right" style="margin-top:-25px;">
                        <button class="btn btn-secondary dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            Опції
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button type="submit" class="dropdown-item" name="newMerchTypeSave" value="Submit">
                                Зберегти
                            </button>
                            <button class="dropdown-item" name="cancel" value="Submit">
                                Відмінити
                            </button>
                        </div>
                    </div>
                    <div class="space-between-lots">
                        <div class="separator"></div>
                    </div>
                <?php
                }
                foreach ($positions as $position) {
                    if ($_GET['MerchTypeEdit'] === $position['id']) {?>
                        <div class="content-header">
                            <h2>
                                <input style="text-align: center;"
                                       name="MerchTypeEditName"
                                       value="<?= $position['merch_type_name'] ?>"
                                >
                            </h2>
                        </div>
                        <div class="dropdown float-right" style="margin-top:-25px;">
                            <button class="btn btn-secondary dropdown-toggle"
                                    type="button"
                                    id="dropdownMenuButton"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                Опції
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button type="submit" class="dropdown-item" name="MerchTypeEditSave"
                                        value="<?= $position['id'] ?>">
                                    Зберегти
                                </button>
                                <button class="dropdown-item" name="cancel" value="Submit">
                                    Відмінити
                                </button>
                            </div>
                        </div>
                        <div class="space-between-lots">
                            <div class="separator"></div>
                        </div>
                    <?php
                    } else {
                        if ($merchTypesDisplayBlock !== true) { ?>
                            <div class="content-header">
                                <h2>
                                    <?= $position['merch_type_name'] ?>
                                </h2>
                            </div>
                            <div class="dropdown float-right" style="margin-top:-25px;">
                                <button class="btn btn-secondary dropdown-toggle"
                                        type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                    Опції
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item" name="MerchTypeEdit" value="<?= $position['id'] ?>">
                                        Редагувати
                                    </button>
                                    <button class="dropdown-item" name="MerchTypeDelete" value="<?= $position['id'] ?>">
                                        Видалити
                                    </button>
                                </div>
                            </div>
                            <div class="space-between-lots">
                                <div class="separator"></div>
                            </div>
                            <?php
                            foreach ($underPositions as $underPosition) {
                                if ($underPosition['merch_type_id'] === $position['id']) {?>
                                    <div class="full-length-back position-relative">
                                        <div class="dropdown position-absolute"
                                             style="margin-top:-25px; top:40px; right: 15px;">
                                            <button class="btn btn-info dropdown-toggle"
                                                    type="button" id="dropdownMenuButton"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    style="height: 40px;"
                                            >
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button class="dropdown-item" name="MerchUnderTypeEdit"
                                                        value="<?= $underPosition['id'] ?>">
                                                    Редагувати
                                                </button>
                                                <button class="dropdown-item" name="MerchUnderTypeDelete"
                                                        value="<?= $underPosition['id'] ?>">
                                                    Видалити
                                                </button>
                                            </div>
                                        </div>
                                        <div class="info-container">
                                            <div class="info-container-img">
                                                <img src="<?= $underPosition['img'] ?>" alt="">
                                            </div>
                                            <div class="info-container-text">
                                                <div class="info-container-text-header">
                                                    <h2>
                                                        <?= $underPosition['merch_under_type_name'] ?>
                                                    </h2>
                                                </div>
                                                <div class="info-container-text-desc">
                                                    <?= $underPosition['description'] ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-block-holder">
                                            <?php foreach ($colourPacks as $colour) {
                                                if ($underPosition['id'] === $colour['merch_under_type_id']) { ?>
                                                    <div class="color-block"
                                                         style="background-color: <?= $colour['color'] ?>;"
                                                         data-toggle="tooltip" data-placement="top" 
                                                         title="<?= $colour['description'] ?>">
                                                        <div class="color-block-text" style="color: <?= $colour['textColor'] ?>">
                                                            <?= $colour['article'] ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } ?>
                                        </div>
                                        <div class="size-table-div">
                                            <table class="table" style="background-color: white;">
                                                <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    <?php foreach ($availableSizes as $availableSize) {
                                                        $i = 0;
                                                        if ($underPosition['id'] == $availableSize['merch_under_type_id']) {

                                                            $availableSizeParamEmptinessCounter = 0;
                                                            $iterationCounter = 0;

                                                            foreach ($availableSize as $size) {
                                                                $iterationCounter += 1;
                                                                if ($size === null) {
                                                                    $availableSizeParamEmptinessCounter += 1;
                                                                }
                                                            }

                                                            if ($availableSizeParamEmptinessCounter  === ($iterationCounter - 2)) {
                                                                $availableSizesTableDisplay = 'display: none';
                                                            } else {
                                                                $availableSizesTableDisplay = '';
                                                            }

                                                            foreach ($availableSize as $size) {
                                                                if (isset($size) &&
                                                                    (key($availableSize) !== 'merch_under_type_id') &&
                                                                    (key($availableSize) !== 'id') &&
                                                                    !($i % 2)) {?>
                                                                    <th scope="col"><?= substr(key($availableSize), 0, -2); ?></th>
                                                                    <?php
                                                                }
                                                                next($availableSize);
                                                                $i += 1;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                </thead>
                                                <tbody style="<?= $availableSizesTableDisplay ?>;">
                                                <tr>
                                                    <th scope="row" >a (см)</th>
                                                    <?php foreach ($availableSizes as $availableSize) {
                                                        $i = 0;
                                                        if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                            foreach ($availableSize as $size) {
                                                                if (isset($size) && !($i % 2) && !($i === 0) && !($i === 1)) { ?>
                                                                    <th scope="col"><?= $size ?></th>
                                                                    <?php
                                                                }
                                                                $i += 1;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <tr>
                                                    <th scope="row">b (см)</th>
                                                    <?php foreach ($availableSizes as $availableSize) {
                                                        $i = 0;
                                                        if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                            foreach ($availableSize as $size) {
                                                                if (isset($size) && ($i % 2) && !($i === 0) && !($i === 1)) { ?>
                                                                    <th scope="col"><?= $size ?></th>
                                                                    <?php
                                                                }
                                                                $i += 1;
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="position-price">
                                            <h2>
                                                Ціна: <?= $underPosition['price'] ?> грн
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="space-between-lots"></div>
                                    <?php
                                }
                            }
                        }
                    }
                }?>
            </form>
        </div>
    </div>
</div>

<?php include './templates/footer.php'; ?>
