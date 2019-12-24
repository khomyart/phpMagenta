<?php
$currentScript = basename($_SERVER['SCRIPT_FILENAME']);

$merchCss = $currentScript == 'merch.php' ? 'active' : '';
$colorCss = $currentScript == 'colors.php' ? 'active' : '';

if ($_POST['logout_button']) {
    session_destroy();
    header('location: control.php');
    die();
}

?>

<div class="container">
    <div class="row">
    <div class="col">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Magenta Print</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown" >
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $merchCss; ?>" href="./merch.php">Товари</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $colorCss; ?>" href="./colors.php">Кольори</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button class="btn dropdown-toggle"
                            type="button"
                            id="dropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                    >
                        <?= $_SESSION['auth']['nickname']?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form action="" method="post">
                            <button type="submit"
                                    class="dropdown-item"
                                    name="logout_button"
                                    value="logout"
                            >
                                Вилогуватись
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    </div>
</div>
