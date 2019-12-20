

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
            <button class="dropdown-item" name="newMerchUnderTypeDelete"
                    value="Submit">
                Відмінити
            </button>
        </div>
    </div>
    <div class="info-container">
        <div class="info-container-img d-flex flex-column justify-content-center align-items-center">
            <label>Посилання на зображення</label>
            <input name="newMerchUnderTypeImg" style="width: 100%;">
        </div>
        <div class="info-container-text">
            <div class="info-container-text-header d-flex flex-column justify-content-center align-items-center">
                <label>Заголовок</label>
                <h2>
                    <input name="newMerchUnderTypeHeader">
                </h2>
            </div>
            <div class="info-container-text-desc d-flex flex-column justify-content-center align-items-center">
                <label>Опис</label>
                <textarea name="newMerchUnderTypeDesc" style="height: 160px; width: 350px;"></textarea>
            </div>
        </div>
    </div>
    <div class="color-block-holder">
        <?php
        $i=0;
        foreach ($availableColours as $availableColour) {
           ?>
            <div style="margin: 0px 15px 15px 15px;">
                <input class="form-check-input" type="checkbox" id="<?=$i?>" value="<?=$availableColour['value']?>">
                <label class="form-check-label" for="<?=$i?>"> <?=$availableColour['value']?>, <?=$availableColour['article']?>
                    <div style="width: 20px; height: 20px; background-color: <?=$availableColour['value']?>; float: right; margin-left: 5px;">
                    </div>
                </label>
            </div>
        <?php
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
                <th scope="row"><input style="width: 40px;" type="number" name="m_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="m_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="l_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="xl_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="xxl_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="3xl_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="4xl_a"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="5xl_a"></th>
            </tr>
            <tr>
                <th scope="row">b (см)</th>
                <th scope="row"><input style="width: 40px;" type="number" name="s_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="m_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="l_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="xl_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="xxl_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="3xl_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="4xl_b"></th>
                <th scope="row"><input style="width: 40px;" type="number" name="5xl_b"></th>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="position-price">
        <h2>
            Ціна: <input type="number" name="price"> грн
        </h2>
    </div>
</div>

