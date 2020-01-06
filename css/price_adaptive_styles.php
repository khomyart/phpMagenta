<style>
    @media (max-width: 1550px) {
        .navbar-site-nav-items {
            padding: 0 1.8rem;
            font-size: 1.1rem;
        }

        .navbar-site-logos-items {
            padding: 0 2rem;
            font-size: 1.1rem;
        }

    }

    @media (max-width: 1350px) {
        .container {
            width: 90vw;
        }

        .navbar-site-nav-items {
            padding: 0 1rem;
            font-size: 1.1rem;
        }

        .navbar-site-logos-items {
            padding: 0 0.8rem;
            font-size: 1.1rem;
        }

        .magenta-under-logo {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 1250px) {
        .full-length-back {
            width: 93%;
        }
    }

    @media (max-width: 1000px) {
        .menu-logo {
            left: 0.5rem;
        }

        .space-between-lots {
            width: 98%;
        }

        .container {
            width: 100%;
        }

        .navbar-site-nav-items {
            padding: 0 0.8rem;
            font-size: 1.1rem;
        }

        .navbar-site-logos-items {
            padding: 0 1rem;
            font-size: 1.1rem;
        }

        .page-logo {
            width: 98%;
            min-height: 30vh;
        }

        .info-container {
            width: 95%;
        }
    }

    @media (max-width: 840px) {
        .menu-logo {
            left: 0.1rem;
        }

        .container {
            width: 100%;
        }

        .navbar-site-nav-items {
            padding: 0 0.5rem;
            font-size: 1.1rem;
            display: inline-block;
        }

        .navbar-site-logos-items {
            padding: 0 0.5rem;
            font-size: 1.1rem;
            display: inline-block;
        }

        .page-logo {
            width: 98%;
            min-height: 30vh;
        }

        .page-logo-image {
            transform: translate(-50%, -49%) scale(0.6);
        }

        .full-length-back {
            display: flex;
            flex-direction: column;
            width: 98%;
            justify-content: center;
            align-items: center;
        }

        .g {
            background-color: rgba(128, 128, 128, 0.096);
        }

        .info-container {
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
            width: 95%;
        }

        .info-container-img {
            margin: 0rem;
            height: 100%;
            width: 50%;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .info-container-img img {
            min-width: 100%;
            min-height: 100%;
            overflow: hidden;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.3);
        }

        .info-container-text {
            padding: 0 2rem;
            width: 50%;
            text-align: justify;
        }

        .man-woman-container {
            padding-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex-wrap: wrap;
            width: 100%;
            min-height: 53vh;
            max-height: 85vh;
            box-sizing: border-box;
            margin-top: 0rem;
        }

        .man {
            width: 32%;
            min-width: 20%;
            height: 23vh;
            flex-grow: 0;
        }
        .woman {
            width: 32%;
            min-width: 20%;
            height: 23vh;
            flex-grow: 0;
        }

        .child {
            width: 32%;
            min-width: 20%;
            height: 23vh;
            flex-grow: 0;
        }

        .hat {
            min-width: 48.5%;
            height: 23vh;
            flex-grow: 0;
        }

        .bag {
            min-width: 48.5%;
            height: 23vh;
            flex-grow: 0;
        }
    }

    @media (max-width: 755px) {
        html {
            font-size: 15px;
        }

        .container {
            width: 100%;
        }
        .relative-for-menu {
            top: 1rem;
            transition: all 0.25s ease-in-out;
        }

        .relative-for-menu.relative-for-menu-activated {
            top: 0rem;
        }

        .menu-label {
            transform: scale(0);
        }
        .menu-label.menu-label-activated {
            transform: scale(0);
        }

        .menu-logo {
            left: 1rem;
            width: 4rem;
            height: 4rem;
            background-color: #f3f3f3;
            position: absolute;
            cursor: pointer;
            display: flex;
            transition: all 0.5s ease-in-out;
            transform: rotate(45deg);
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px 2px rgb(128, 0, 128);
        }

        .menu-logo-img {
            width: 2.8rem;
            height: 2.5rem;
            transition: all 1s ease-in-out;
            transform: rotate(-45deg);
        }

        .menu-logo.activated-logo {
            margin-left: -13px;
            transform: rotate(-180deg);
            box-shadow: 0 0 10px 2px rgba(0, 0, 0, 0);
        }

        .menu-logo-img.activated-menu-image {
            width: 3rem;
            height: 2.7rem;
            transform: rotate(-180deg);
        }

        .navbar {
            margin-left: 0px;
            width: 0%;
            height: 4rem;
            background-color: #f3f3f3;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            transition: all 0.5s ease-in-out;
            margin-left: 0px;
        }

        .navbar.activated {
            transition-delay: 0.5s;
            width: 100%;
            margin-left: 0px;
        }

        .navbar-left-padding {
            transition: all 0.5s ease-in-out;
            width: 0%;
        }

        .navbar-left-padding.navbar-left-padding-activated {
            width: 10%;
        }

        .navbar.activated {
            height: 9rem;
            margin-left: 0px;
            width: 100%;
        }

        .menu-center {
            height: 0%;
            transition: all 0.5s ease-in-out;
            border-left: 2px solid rgba(128, 0, 128, 0);
        }

        .navbar-site-nav-parent-div {
            width: 40%;
        }

        .navbar-site-nav-items {
            padding: 0.2rem 0.5rem;
            display: block;
            font-size: 1.2rem;
            transform: scale(0);
        }

        .navbar-site-logos-items {
            display: block;
            padding: 0.2rem 0.5rem;
            font-size: 1.2rem;
            transform: scale(0);
        }

        .page-logo {
            width: 98%;
            min-height: 32vh;
        }

        .page-logo-image {
            transform: translate(-50%, -45%) scale(0.6);
        }

        .content-header {
            padding: 1.5rem 0 0 0;
            font-weight: normal;
        }

        .content-header-add-margin {
            margin-bottom: 1.5rem;
        }

        .full-length-back {
            display: flex;
            flex-direction: column;
            width: 96%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        .g {
            background-color: rgba(128, 128, 128, 0.096);
        }

        .info-container {
            padding: 0rem;
            display: flex;
            flex-direction: column;
            width: 93%;
            height: auto;
        }

        .info-container-img {
            width: 90vw;
            height: 15rem;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .info-container-img img {
            min-width: 100%;
            min-height: 100%;
            overflow: hidden;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.227);
        }

        .info-container-text {
            padding: 0 0rem;
            width: 98%;
            align-items: center;
        }

        .info-container-text-header {
            padding-top: 1rem;
            align-items: center;
        }

        .info-container-text-desc {
            padding-top: 1rem;
            overflow: auto;
            font-size: 1.15rem;
            height: 80%;
            text-align: center;
        }

        .color-block-holder {
            width: 90%;
        }

        .size-table-div {
            flex-direction: column-reverse;
            margin-left: 0px;
            width: 96%;
        }

        .size-table-holder {
            display: flex;
            justify-content: center;
        }

        .size-type-image {
            padding-right: 0px;
            padding-top: 0px;
            padding-bottom: 10px;
        }

        .man-woman-container {
            padding: 0rem;
            display: flex;
            justify-content: center;
            align-items: stretch;
            flex-wrap: wrap;
            width: 100%;
            min-height: 170vh;
        }

        .man {
            width: 98%;
            min-width: 310px;
            height: 30vh;
            flex-grow: 0;
        }

        .man img {
            transform: translate(-50%, -48%) scale(0.21);
        }

        .man:hover img {
            transform: translate(-50%, -48%) scale(0.23);
        }
        .woman {
            width: 98%;
            min-width: 310px;
            height: 30vh;
            flex-grow: 0;
        }

        .child {
            width: 98%;
            min-width: 310px;
            height: 30vh;
            flex-grow: 0;
        }

        .hat {
            width: 98%;
            min-width: 310px;
            height: 30vh;
            flex-grow: 0;
        }

        .bag {
            width: 98%;
            min-width: 310px;
            height: 30vh;
            flex-grow: 0;
        }

        .footer {
            font-size: 1.15rem;
        }
    }

    @media (min-height: 1100px) {
        .page-logo {
            width: 98%;
            min-height: 25vh;
        }
        .page-logo-image {
            transform: translate(-50%, -40%) scale(1);
        }

        .info-container {
            width: 95%;
        }

        .man-woman-container {
            padding-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex-wrap: wrap;
            width: 100%;
            min-height: 50vh;
            box-sizing: border-box;
            margin-top: 0.5rem;
        }

        .man {
            width: 32%;
            min-width: 20%;
            height: 22vh;
            flex-grow: 0;
        }
        .woman {
            width: 32%;
            min-width: 20%;
            height: 22vh;
            flex-grow: 0;
        }

        .child {
            width: 32%;
            min-width: 20%;
            height: 22vh;
            flex-grow: 0;
        }

        .hat {
            min-width: 48.5%;
            height: 22vh;
            flex-grow: 0;
        }

        .bag {
            min-width: 48.5%;
            height: 22vh;
            flex-grow: 0;
        }
    }
    /*LOGO*/
</style>
