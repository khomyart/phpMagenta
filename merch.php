<?php
include './imports.php';
header("Content-Type: text/html; charset=UTF-8");

$searchValue = '';
$availableColours = getListOfAvailableColors();

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

if (isset($_GET['MerchTypeCopy'])) {
    $pastedItemId = copyUnit($_GET['MerchTypeCopy']);

    if ($pastedItemId) {
        header('Location: merch.php?scrollTo='.$pastedItemId);
    } else {
        die ('bla');
    };

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
$addingImageLabelDisplay = '';

if ($targetFile) {
    $addingImageInputType = 'hidden';
    $addingImageLabelDisplay = 'none';
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
        'S_c' => $_GET['newMerchUnderTypeAvailableSizes']['s_c'],
        'M_a' => $_GET['newMerchUnderTypeAvailableSizes']['m_a'],
        'M_b' => $_GET['newMerchUnderTypeAvailableSizes']['m_b'],
        'M_c' => $_GET['newMerchUnderTypeAvailableSizes']['m_c'],
        'L_a' => $_GET['newMerchUnderTypeAvailableSizes']['l_a'],
        'L_b' => $_GET['newMerchUnderTypeAvailableSizes']['l_b'],
        'L_c' => $_GET['newMerchUnderTypeAvailableSizes']['l_c'],
        'XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['xl_a'],
        'XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['xl_b'],
        'XL_c' => $_GET['newMerchUnderTypeAvailableSizes']['xl_c'],
        'XXL_a' => $_GET['newMerchUnderTypeAvailableSizes']['xxl_a'],
        'XXL_b' =>  $_GET['newMerchUnderTypeAvailableSizes']['xxl_b'],
        'XXL_c' =>  $_GET['newMerchUnderTypeAvailableSizes']['xxl_c'],
        '3XL_a' =>  $_GET['newMerchUnderTypeAvailableSizes']['3xl_a'],
        '3XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['3xl_b'],
        '3XL_c' =>  $_GET['newMerchUnderTypeAvailableSizes']['3xl_c'],
        '4XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['4xl_a'],
        '4XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['4xl_b'],
        '4XL_c' => $_GET['newMerchUnderTypeAvailableSizes']['4xl_c'],
        '5XL_a' => $_GET['newMerchUnderTypeAvailableSizes']['5xl_a'],
        '5XL_b' => $_GET['newMerchUnderTypeAvailableSizes']['5xl_b'],
        '5XL_c' => $_GET['newMerchUnderTypeAvailableSizes']['5xl_c'],
        ];

        foreach ($availableSizeParams as &$availableSizeParam) {
            if (empty($availableSizeParam)) {
                $availableSizeParam = NULL;
            }
        }

    insertUnit('size', $availableSizeParams);
    header('Location: merch.php?scrollTo='.$lastAddedMerchUnderTypeId['id'] );
}

/* Performs merch under type edit with proper ID */
if (isset($_GET['MerchUnderTypeEdit'])) {
    $merchUnderTypeQuery = 'SELECT * FROM `merch_under_types` as m 
                            LEFT JOIN `available_sizes` as a ON m.id = a.merch_under_type_id 
                            LEFT JOIN `merch_types` as mt ON m.merch_type_id = mt.id 
                            WHERE m.id = :merchUnderTypeId;';

    $merchUnderTypeParam = [
        'merchUnderTypeId' => $_GET['MerchUnderTypeEdit'],
    ];
    $merchUnderTypeEditGeneralInfoAndSizes = getRow($merchUnderTypeQuery, $merchUnderTypeParam);

    $addingImageInputType = 'hidden';

    $merchUnderTypeColorQuery = 'SELECT `color_id` FROM `merch_under_types_color` WHERE `merch_under_type_id` = :merchUnderTypeId;';
    $merchUnderTypeEditSelectedColors = getAllRows($merchUnderTypeColorQuery, $merchUnderTypeParam);
    foreach ($merchUnderTypeEditSelectedColors as &$merchUnderTypeEditSelectedColor) {
        $merchUnderTypeEditSelectedColor = $merchUnderTypeEditSelectedColor['color_id'];
    }
};
/*Update merch subtype block*/
if (isset($_GET['existedMerchUnderTypeSave'])) {

    $merchUnderTypeUpdateGeneralInfoQuery = 'UPDATE `merch_under_types` as m 
                                                LEFT JOIN `available_sizes` as a ON m.id = a.merch_under_type_id 
                                                SET 
                                                m.merch_type_id = :merchTypeId,
                                                m.merch_under_type_name = :merchUnderTypeName,
                                                m.img = :img,
                                                m.description = :description,
                                                m.price = :price,
                                                a.S_a = :S_b, a.S_b = :S_b, a.S_c = :S_c, 
                                                a.M_a = :M_a, a.M_b = :M_b, a.M_c = :M_c, 
                                                a.L_a = :L_a, a.L_b = :L_b, a.L_c = :L_c, 
                                                a.XL_a = :XL_a, a.XL_b = :XL_b, a.XL_c = :XL_c, 
                                                a.XXL_a = :XXL_a, a.XXL_b = :XXL_b, a.XXL_c = :XXL_c, 
                                                a.3XL_a = :3XL_a, a.3XL_b = :3XL_b, a.3XL_c = :3XL_c, 
                                                a.4XL_a = :4XL_a, a.4XL_b = :4XL_b, a.4XL_c = :4XL_c, 
                                                a.5XL_a = :5XL_a, a.5XL_b = :5XL_b, a.5XL_c = :5XL_c
                                                WHERE m.id = :merchUnderTypeId';

    $merchUnderTypeUpdateGeneralInfoParams = [
        'merchUnderTypeId' => $_GET['existedMerchUnderTypeSave'],
        'merchTypeId' => $_GET['existedMerchUnderType']['listOfTypes'], /* merchType ID */
        'merchUnderTypeName' => $_GET['existedMerchUnderType']['header'],
        'img' => $_GET['existedMerchUnderType']['img'],
        'description' => nl2br($_GET['existedMerchUnderType']['desc']),
        'price' => $_GET['existedMerchUnderType']['price'],
        'S_a' => $_GET['existedMerchUnderTypeAvailableSizes']['s_a'],
        'S_b' => $_GET['existedMerchUnderTypeAvailableSizes']['s_b'],
        'S_c' => $_GET['existedMerchUnderTypeAvailableSizes']['s_c'],
        'M_a' => $_GET['existedMerchUnderTypeAvailableSizes']['m_a'],
        'M_b' => $_GET['existedMerchUnderTypeAvailableSizes']['m_b'],
        'M_c' => $_GET['existedMerchUnderTypeAvailableSizes']['m_c'],
        'L_a' => $_GET['existedMerchUnderTypeAvailableSizes']['l_a'],
        'L_b' => $_GET['existedMerchUnderTypeAvailableSizes']['l_b'],
        'L_c' => $_GET['existedMerchUnderTypeAvailableSizes']['l_c'],
        'XL_a' => $_GET['existedMerchUnderTypeAvailableSizes']['xl_a'],
        'XL_b' => $_GET['existedMerchUnderTypeAvailableSizes']['xl_b'],
        'XL_c' => $_GET['existedMerchUnderTypeAvailableSizes']['xl_c'],
        'XXL_a' => $_GET['existedMerchUnderTypeAvailableSizes']['xxl_a'],
        'XXL_b' =>  $_GET['existedMerchUnderTypeAvailableSizes']['xxl_b'],
        'XXL_c' =>  $_GET['existedMerchUnderTypeAvailableSizes']['xxl_c'],
        '3XL_a' =>  $_GET['existedMerchUnderTypeAvailableSizes']['3xl_a'],
        '3XL_b' => $_GET['existedMerchUnderTypeAvailableSizes']['3xl_b'],
        '3XL_c' =>  $_GET['existedMerchUnderTypeAvailableSizes']['3xl_c'],
        '4XL_a' => $_GET['existedMerchUnderTypeAvailableSizes']['4xl_a'],
        '4XL_b' => $_GET['existedMerchUnderTypeAvailableSizes']['4xl_b'],
        '4XL_c' => $_GET['existedMerchUnderTypeAvailableSizes']['4xl_c'],
        '5XL_a' => $_GET['existedMerchUnderTypeAvailableSizes']['5xl_a'],
        '5XL_b' => $_GET['existedMerchUnderTypeAvailableSizes']['5xl_b'],
        '5XL_c' => $_GET['existedMerchUnderTypeAvailableSizes']['5xl_c'],
    ];

    foreach ($merchUnderTypeUpdateGeneralInfoParams as &$merchUnderTypeUpdateGeneralInfoParam) {
        if (empty($merchUnderTypeUpdateGeneralInfoParam)) {
            $merchUnderTypeUpdateGeneralInfoParam = NULL;
        }
    }

    $merchUnderTypeUpdateGeneralInfoColorParams = ['merchUnderTypeId' => $_GET['existedMerchUnderTypeSave']];
    removeUnit('colors', $merchUnderTypeUpdateGeneralInfoColorParams);

    foreach ($_GET['existedMerchUnderTypeColours'] as $colour) {
        $addColourParams = [
            'merchUnderTypeId' => $_GET['existedMerchUnderTypeSave'],
            'colorId' => $colour,
        ];

        insertUnit('merchUnderTypeColor', $addColourParams);
    }

    if (performQuery($merchUnderTypeUpdateGeneralInfoQuery, $merchUnderTypeUpdateGeneralInfoParams)) {
        header('Location: merch.php?scrollTo='.$_GET['existedMerchUnderTypeSave']);
    }

}

if (empty($targetFile)) {
    $targetFile = $merchUnderTypeEditGeneralInfoAndSizes['img'];
    $merchUnderTypeEditImage = $merchUnderTypeEditGeneralInfoAndSizes['img'];
} else {
    $imgMerchUnderTypeZIndex = 4000;
    $merchUnderTypeEditImage = $targetFile;
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
if ($_GET['MerchTypeEdit'] || $_GET['newMerchUnderType'] || $_GET['MerchUnderTypeEdit']) {
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
                if (isset($_GET['MerchUnderTypeEdit'])) {
                    unset($_GET); ?>
                    <!--MerchUnderTypeEdit-->
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
                                <button class="dropdown-item" name="existedMerchUnderTypeSave"
                                        value="<?= $merchUnderTypeEditGeneralInfoAndSizes['merch_under_type_id'] ?>">
                                    Зберегти
                                </button>
                                <button class="dropdown-item" name="cancel"
                                        value="Submit">
                                    Відмінити
                                </button>
                            </div>
                        </div>
                        <div class="input-group mt-4 col-6">
                            <div class="custom-file d-flex justify-content-between">
                                <input type="file" class="uploading-image-input" form="uploadingFormFile" name="fileToUpload" id="fileToUpload">
                                <button class="uploading-button-input" type="submit" form="uploadingFormFile" name="submit"
                                        value="<?= $merchUnderTypeEditGeneralInfoAndSizes['merch_under_type_id'] ?>">
                                    Завантажити
                                </button>
                            </div>
                        </div>
                        <div style="margin-top:30px;">
                            <select class="form-control" name="existedMerchUnderType[listOfTypes]">
                                <option value="">
                                    Вид товару
                                </option>
                                <?php
                                foreach ($positions as $position) {
                                    if ($merchUnderTypeEditGeneralInfoAndSizes['merch_type_name']==$position['merch_type_name']) {?>
                                        <option selected value="<?= $position['id'] ?>">
                                            <?= $position['merch_type_name'] ?>
                                        </option>
                                    <?php } else { ?>
                                        <option value="<?= $position['id'] ?>">
                                            <?= $position['merch_type_name'] ?>
                                        </option>
                                    <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="info-container">
                            <div class="info-container-img d-flex flex-column justify-content-center align-items-center">
                                <img src="<?= $merchUnderTypeEditImage ?>" style="z-index: <?= $imgMerchUnderTypeZIndex ?>;" alt="">
                                <input type="<?= $addingImageInputType ?>" class="form-control" name="existedMerchUnderType[img]"
                                       style="width: 100%;" value="<?= $merchUnderTypeEditImage ?>">
                            </div>
                            <div class="info-container-text">
                                <div class="info-container-text-header d-flex flex-column justify-content-center align-items-center">
                                    <label>Заголовок</label>
                                    <h2>
                                        <input class="form-control" style="width: 350px;" name="existedMerchUnderType[header]"
                                               value="<?= $merchUnderTypeEditGeneralInfoAndSizes['merch_under_type_name'] ?>">
                                    </h2>
                                </div>
                                <div class="info-container-text-desc d-flex flex-column justify-content-center align-items-center">
                                    <label>Опис</label>
                                    <textarea class=" d-inline-block form-control" name="existedMerchUnderType[desc]"
                                              style="height: 160px; width: 350px;"><?= str_replace('<br />', '', $merchUnderTypeEditGeneralInfoAndSizes['description']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="color-block-holder">
                            <?php
                            $i=0;
                            foreach ($availableColours as $availableColour) {?>
                                <div style="margin: 0px 25px 15px 25px;">
                                    <?php
                                    $selectedColorKey = array_search($availableColour['id'], $merchUnderTypeEditSelectedColors);
                                    if (is_int($selectedColorKey)) { ?>
                                        <input class="form-check-input color_checkbox" type="checkbox" id="<?= $i ?>"
                                               checked name="existedMerchUnderTypeColours[<?= $i ?>]"
                                               value="<?=$availableColour['id']?>">
                                        <?php
                                    } else { ?>
                                        <input class="form-check-input color_checkbox" type="checkbox" id="<?= $i ?>"
                                               name="existedMerchUnderTypeColours[<?= $i ?>]"
                                               value="<?=$availableColour['id']?>">
                                    <?php
                                    }?>
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
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[s_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['S_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[m_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['M_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[l_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['L_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xl_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XL_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xxl_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XXL_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[3xl_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['3XL_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[4xl_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['4XL_a'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[5xl_a]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['5XL_a'] ?>"></th>
                                </tr>
                                <tr>
                                    <th scope="row">b (см)</th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[s_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['S_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[m_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['M_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[l_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['L_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xl_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XL_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xxl_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XXL_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[3xl_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['3XL_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[4xl_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['4XL_b'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[5xl_b]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['5XL_b'] ?>"></th>
                                </tr>
                                <tr>
                                    <th scope="row">c (см)</th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[s_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['S_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[m_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['M_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[l_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['L_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xl_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XL_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[xxl_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['XXL_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[3xl_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['3XL_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[4xl_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['4XL_c'] ?>"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="existedMerchUnderTypeAvailableSizes[5xl_c]"
                                                           value="<?= $merchUnderTypeEditGeneralInfoAndSizes['5XL_c'] ?>"></th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="position-price">
                            <h2>
                                Ціна: <input class="form-control" type="number" name="existedMerchUnderType[price]" value="<?= $merchUnderTypeEditGeneralInfoAndSizes['price'] ?>"> грн
                            </h2>
                        </div>
                    </div>
                    <div class="space-between-lots"></div>
                    <!--MerchUnderTypeEdit close-->
                <?php
                } ?>

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
                        <div class="input-group mt-4 col-6">
                            <div class="custom-file d-flex justify-content-between">
                                <input type="file" class="uploading-image-input" form="uploadingFormFile" name="fileToUpload" id="fileToUpload">
                                <button class="uploading-button-input" type="submit" form="uploadingFormFile" name="submit">
                                    Завантажити
                                </button>
                            </div>
                        </div>
                        <div style="margin-top:30px;">
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
                        <div class="info-container">
                            <div class="info-container-img d-flex flex-column justify-content-center align-items-center">
                                <img src="<?= $targetFile ?>" style="z-index: <?= $imgMerchUnderTypeZIndex ?>;" alt="">
                                <label style="display: <?= $addingImageLabelDisplay ?>;" ">Посилання на зображення</label>
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
                                <tr>
                                    <th scope="row">c (см)</th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[s_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[m_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[l_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xl_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[xxl_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[3xl_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[4xl_c]"></th>
                                    <th scope="row"><input style="width: 40px;" type="number" name="newMerchUnderTypeAvailableSizes[5xl_c]"></th>
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
                                    <div id="<?= $underPosition['id'] ?>" class="full-length-back position-relative">
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
                                                <button class="dropdown-item" name="MerchTypeCopy"
                                                        value="<?= $underPosition['id'] ?>">
                                                    Копіювати
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
                                        <?php
                                        foreach ($availableSizes as $availableSize) {
                                            if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                $merchUnderTypeAvailableSizeDisplayBlock = 'flex';
                                                $sizeTableNullPointer = 2;
                                                $sizeTablePointerIndex = 0;

                                                foreach ($availableSize as $size) {
                                                    if ((key($availableSize) !== 'merch_under_type_id')
                                                        && (key($availableSize) !== 'id')) {
                                                        if ($size == null) {
                                                            $sizeTableNullPointer += 1;
                                                        }
                                                    }
                                                    next($availableSize);
                                                    $sizeTablePointerIndex += 1;
                                                }

                                                if ($sizeTableNullPointer === $sizeTablePointerIndex) {
                                                    $merchUnderTypeAvailableSizeDisplayBlock = 'none';
                                                } ?>
                                                <div class="size-table-div d-<?= $merchUnderTypeAvailableSizeDisplayBlock ?> w-100 flex-row-reverse justify-content-center">
                                        <?php
                                            }
                                        } ?>
                                            <div>
                                                <table class="table" style="background-color: white;">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <?php foreach ($availableSizes as $availableSize) {
                                                            /* Counter which allows do proper sizes display control, used in %2(B), %3(C) */
                                                            $i = 1;
                                                            if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                                foreach ($availableSize as $size) {
                                                                    if (isset($size)
                                                                        && (key($availableSize) !== 'merch_under_type_id')
                                                                        && (key($availableSize) !== 'id')
                                                                        && (($i % 3) == 0)) {?>
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
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" >a (см)</th>
                                                        <?php foreach ($availableSizes as $availableSize) {
                                                            if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                                $i = 1;
                                                                foreach ($availableSize as $size) {
                                                                    if (isset($size)
                                                                        && (key($availableSize) !== 'merch_under_type_id')
                                                                        && (key($availableSize) !== 'id')
                                                                        && (($i % 3) == 0))  { ?>
                                                                        <th scope="col"><?= $size ?></th>
                                                                        <?php
                                                                    }
                                                                    next($availableSize);
                                                                    $i += 1;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">b (см)</th>
                                                        <?php foreach ($availableSizes as $availableSize) {
                                                            if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                                $i = 0;
                                                                foreach ($availableSize as $size) {
                                                                    if (isset($size)
                                                                        && (key($availableSize) !== 'merch_under_type_id')
                                                                        && (key($availableSize) !== 'id')
                                                                        && (($i % 3) == 0)) { ?>
                                                                        <th scope="col"><?= $size ?></th>
                                                                        <?php
                                                                    }
                                                                    next($availableSize);
                                                                    $i += 1;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tr>

                                                    <?php foreach ($availableSizes as $availableSize) {
                                                        /*if C field is not empty - show it, else hide*/
                                                        if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                            $i = -1;
                                                            $cFieldNullPointer = 0;
                                                            $cFieldPointerIndex = 0;
                                                            foreach ($availableSize as $size) {
                                                                if ((key($availableSize) !== 'merch_under_type_id')
                                                                    && (key($availableSize) !== 'id')
                                                                    && (($i % 3) == 0)) {
                                                                    if ($size == null) {
                                                                        $cFieldNullPointer += 1;
                                                                    }
                                                                    $cFieldPointerIndex += 1;
                                                                }
                                                                next($availableSize);
                                                               $i += 1;
                                                            }

                                                            if ($cFieldNullPointer === $cFieldPointerIndex) {
                                                                $cFieldDisplay = 'display: none;';
                                                            } else {
                                                                $cFieldDisplay = '';
                                                            }
                                                        }
                                                    } ?>

                                                    <tr style="<?= $cFieldDisplay ?>">
                                                        <th scope="row">c (см)</th>
                                                        <?php foreach ($availableSizes as $availableSize) {
                                                            if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                                $i = -1;
                                                                foreach ($availableSize as $size) {
                                                                    if (isset($size)
                                                                        && (key($availableSize) !== 'merch_under_type_id')
                                                                        && (key($availableSize) !== 'id')
                                                                        && (($i % 3) == 0)) { ?>
                                                                        <th scope="col"><?= $size ?></th>
                                                                        <?php
                                                                    }
                                                                    next($availableSize);
                                                                    $i += 1;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="size-type-image">
                                                <?php foreach ($availableSizes as $availableSize) {
                                                    if ($underPosition['id'] == $availableSize['merch_under_type_id']) {
                                                        $i = -1;
                                                        $cFieldNullPointer = 0;
                                                        $cFieldPointerIndex = 0;
                                                        foreach ($availableSize as $size) {
                                                            if ((key($availableSize) !== 'merch_under_type_id')
                                                                && (key($availableSize) !== 'id')
                                                                && (($i % 3) == 0)) {
                                                                if ($size == null) {
                                                                    $cFieldNullPointer += 1;
                                                                }
                                                                $cFieldPointerIndex += 1;
                                                            }
                                                            next($availableSize);
                                                            $i += 1;
                                                        }

                                                        if ($cFieldNullPointer === $cFieldPointerIndex) { ?>
                                                            <img src="img/BST/sizeTypes/abTypeImage.png" alt="abTypeImage">
                                                            <?php
                                                        } else { ?>
                                                            <img src="img/BST/sizeTypes/abcTypeImage.png" style="margin-top: 20px;" alt="abcTypeImage">
                                                        <?php
                                                        }
                                                    }
                                                } ?>
                                            </div>
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

            <script>
                id = <?= $_GET['scrollTo'] ?>;
                yOffset = -20;
                element = document.getElementById(id);
                y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;

                window.scrollTo({top: y, behavior: 'smooth'});
            </script>
        </div>
    </div>
</div>

<?php include './templates/footer.php'; ?>
