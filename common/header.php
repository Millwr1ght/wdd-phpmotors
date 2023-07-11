    <header>
        <div class="logo">
            <a href="/phpmotors/?action=Home">
                <img src="/phpmotors/images/site/logo.png" alt="PHP Motors logo">
            </a>
        </div>
        <div class="login">
            <?= ((isset($_SESSION['clientData']['clientFirstname'])) ? '<a href="/phpmotors/accounts/">Welcome '. $_SESSION['clientData']['clientFirstname'] .'!</a>': '') . '<a class="login-button" href="/phpmotors/accounts/?action=' . ((isset($_SESSION['clientData']['clientFirstname'])) ? 'logout">Log Out': 'login">My Account') .'</a>'?>
        </div>
    </header>