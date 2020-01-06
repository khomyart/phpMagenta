<?php
include './imports.php';

/* Merch types */
$positions = getListOfMerchTypes($searchValue);
/* Merch under types */
$underPositions = getListOfMerchUnderTypes($searchValue);
/* Colors for particular under types (under positions) */
$colourPacks = getListOfColourPack($searchValue);
/* Sizes for particular under types (under positions) */
$availableSizes = getListOfAvailableSizes($searchValue);

?>

<!DOCTYPE html>
<html>
  <head lang="en">
    <meta charset="UTF-8" />
    <title>"Magenta Print|Price list"</title>
      <!-- Required meta tags -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link href="css/style_price.css" rel="stylesheet" />
      <!-- Bootstrap CSS
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous"> -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <?php
    include './css/price_adaptive_styles.php';
    ?>

  </head>
  <body>
    <div class="container">
      <!--MENU-->
      <div class="relative-for-menu">
        <div class="menu-logo">
          <img class="menu-logo-img" src="/img/BST/magenta-menu-logo.png" />
          <div class="menu-label">
            МЕНЮ
          </div>
          <script>
            $(".menu-logo").click(function() {
              $(".navbar").toggleClass("activated");
              $(".relative-for-menu").toggleClass(
                "relative-for-menu-activated"
              );
              $(".navbar-left-padding").toggleClass(
                "navbar-left-padding-activated"
              );
              $(".menu-center").toggleClass("menu-center-activated");
              $(".menu-logo").toggleClass("activated-logo");
              $(".menu-logo-img").toggleClass("activated-menu-image");
              $(".menu-label").toggleClass("menu-label-activated");
              $(".navbar-site-nav-items").toggleClass(
                "navbar-site-nav-items-activated"
              );
              $(".navbar-site-logos-items").toggleClass(
                "navbar-site-logos-items-activated"
              );
            });
          </script>
        </div>
        <div class="navbar">
          <div class="navbar-left-padding">
            <span></span>
          </div>
          <div class="navbar-site-nav-parent-div">
            <ul class="navbar-site-nav">
              <li class="navbar-site-nav-items">
                <a href="index.php">Головна</a>
                <div class="menu_underlines_navs"></div>
              </li>
              <li class="navbar-site-nav-items">
                <a href="#">Галерея</a>
                <div class="menu_underlines_navs"></div>
              </li>
              <li class="navbar-site-nav-items">
                <a href="price.php">Продаж</a>
                <div class="menu_underlines_navs"></div>
              </li>
              <li class="navbar-site-nav-items">
                <a href="#">Про нас</a>
                <div class="menu_underlines_navs"></div>
              </li>
            </ul>
          </div>
          <div class="menu-center">
            <span></span>
          </div>
          <div class="navbar-site-logos-parent-div">
            <ul class="navbar-site-logos">
              <li class="navbar-site-logos-items">
                <a href="mailto:madzentadruk@gmail.com"
                  ><i class="fa fa-envelope">&nbsp;</i>Пошта</a
                >
                <div class="menu_underlines_logos"></div>
              </li>
              <li class="navbar-site-logos-items">
                <a
                  href="https://www.facebook.com/Magenta-print-105821100833281/"
                  ><i class="fa fa-facebook-square">&nbsp;</i>Facebook</a
                >
                <div class="menu_underlines_logos"></div>
              </li>
              <li class="navbar-site-logos-items">
                <a href="https://www.instagram.com/printmagenta/"
                  ><i class="fa fa-instagram">&nbsp;</i>Instagram</a
                >
                <div class="menu_underlines_logos"></div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--MENU-->

      <!--CONTENT-->
        <?php
        foreach ($positions as $position) {?>
            <div class="content-header">
                <h2>
                    <?= $position['merch_type_name'] ?>
                </h2>
            </div>
            <div class="space-between-lots">
                <div class="separator"></div>
            </div>
            <?php
            foreach ($underPositions as $underPosition) {
                if ($underPosition['merch_type_id'] === $position['id']) {?>
                <div class="full-length-back w">
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
                    <div class="size-table-div" style="display: <?= $merchUnderTypeAvailableSizeDisplayBlock ?>;">
                        <?php
                        }
                        } ?>
                        <div class="size-table-holder">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
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
                                    <th scope="row" >A,см</th>
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
                                    <th scope="row">B,см</th>
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
                                    <th scope="row">C,см</th>
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
                                        <img style="margin-top: -19px;" src="img/BST/sizeTypes/abTypeImage.png" alt="abTypeImage">
                                        <?php
                                    } else { ?>
                                        <img src="img/BST/sizeTypes/abcTypeImage.png" alt="abcTypeImage">
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
        }?>
      <!--CONTENT-->

      <div class="footer">
        <div class="magenta-logo-div">
          <img class="magenta-logo" src="img/BST/magenta-logo.png" alt="" />
        </div>
        <div class="magenta-under-logo">
          <div class="phone-number">
            <table>
              <tr>
                <td align="center" colspan="3">
                  <h3>
                    <i class="fa fa-phone-square"></i>
                    Телефони:
                  </h3>
                </td>
              </tr>
              <tr>
                <td height="5" colspan="3"></td>
              </tr>
              <tr>
                <td>
                  <div class="icons-decor">
                    <i class="fa fa-phone"></i>
                  </div>
                </td>
                <td width="5"></td>
                <td align="left">
                  <a
                    style="text-decoration: underline;
                                                  text-decoration-color: purple;"
                    href="tel:380964303386"
                    >+380964303386</a
                  >
                  (Київстар)
                </td>
                <td vertical-align="center">
                  <div class="icons-decor">
                    <a href="viber://chat?number=380964303386">
                      <img
                        width="20"
                        style="margin-top:5px;"
                        src="/img/BST/icons/viber-brands.svg"
                      />
                    </a>
                  </div>
                </td>
              </tr>
              <tr>
                <td height="7" colspan="3"></td>
              </tr>
              <tr>
                <td>
                  <div class="icons-decor">
                    <i class="fa fa-phone"></i>
                  </div>
                </td>
                <td></td>
                <td align="left">
                  <a
                    style="text-decoration: underline;
                                                  text-decoration-color: purple;"
                    href="tel:380506214211"
                    >+380506214211</a
                  >
                  (Vodafone)
                </td>
              </tr>
            </table>
          </div>
          <div class="shedule">
            <table>
              <tr>
                <td align="center" colspan="3">
                  <h3>
                    <img
                      width="15"
                      style="vertical-align: middle;"
                      src="/img/BST/icons/clock-solid.svg"
                    />
                    Графік роботи:
                  </h3>
                </td>
              </tr>
              <tr>
                <td height="5" colspan="3"></td>
              </tr>
              <tr>
                <td>Понеділок:</td>
                <td width="5"></td>
                <td>10:00 — 19:00</td>
              </tr>
              <tr>
                <td>Вівторок:</td>
                <td></td>
                <td>10:00 — 19:00</td>
              </tr>
              <tr>
                <td>Середа:</td>
                <td></td>
                <td>10:00 — 19:00</td>
              </tr>
              <tr>
                <td>Четвер:</td>
                <td></td>
                <td>10:00 — 19:00</td>
              </tr>
              <tr>
                <td>П'ятниця:</td>
                <td></td>
                <td>10:00 — 19:00</td>
              </tr>
              <tr>
                <td>Субота:</td>
                <td></td>
                <td>10:00 — 15:00</td>
              </tr>
              <tr>
                <td>Неділя:</td>
                <td colspan="2" align="center">Вихідний</td>
              </tr>
            </table>
          </div>
          <div class="address">
            <table>
              <tr>
                <td align="center" colspan="3">
                  <h3>
                    <img
                      width="20"
                      src="/img/BST/icons/place-of-worship-solid.svg"
                    />
                    Адреса:
                  </h3>
                </td>
              </tr>
              <tr>
                <td height="5" colspan="3"></td>
              </tr>
              <tr>
                <td align="center">
                  <a
                    style="
                                            text-decoration: underline;
                                            text-decoration-color: purple;
                                            "
                    href="https://goo.gl/maps/65MSBQRFT82XLG6e8"
                    >м. Луцьк</a
                  >
                </td>
              </tr>
              <tr>
                <td>
                  <a
                    style="
                                            text-decoration: underline;
                                            text-decoration-color: purple;
                                            "
                    href="https://goo.gl/maps/65MSBQRFT82XLG6e8"
                    >вул. Лесі Українки, 45 в магазині
                  </a>
                </td>
              </tr>
              <tr>
                <td align="center">
                  <a
                    style="
                                            text-decoration: underline;
                                            text-decoration-color: purple;
                                            "
                    href="https://goo.gl/maps/65MSBQRFT82XLG6e8"
                    >Анжеліка та AVON</a
                  >
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="under-footer g">
        2019 © Magenta Print, Всі права захищені
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  </body>
</html>
