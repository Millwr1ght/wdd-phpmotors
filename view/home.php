<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/phpmotors/favicon.ico" rel="icon" type="image/x-icon">
    <link rel="stylesheet" href="/phpmotors/css/style.css" media="screen">
    <title>PHP Motors | Home</title>
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
    <?= $nav_list ?>

    <main>
        <h1>Welcome to PHP Motors!</h1>

        <div class="hero-banner">
            <aside id="call-to-action">
                <h2 class="call-heading">DMC Delorean</h2>
                <p>3 Cup holders</p>
                <p>Superman doors</p>
                <p>Fuzzy dice!</p>
            </aside>
            <img id="hero-delorean" src="/phpmotors/images/vehicles/delorean.jpg" alt="The DMC Delorean">
            <a href="/phpmotors/vehicles/?action=details&invId=21" id="hero-call"><img src="/phpmotors/images/site/own_today.png" alt="click here to buy now"></a>
        </div>
        
        <div class="main-content">

            <section class="reviews">
                <h2>DMC Delorean Reviews</h2>
                <ul>
                    <li>"So fast its almost like travelling in time." (4/5)</li>
                    <li>"Coolest ride on the road." (4/5)</li>
                    <li>"I'm feeling Marty McFly" (5/5)</li>
                    <li>"The most futuristic car of our day." (4.5/5)</li>
                    <li>"80's livin and I love it!" (5/5)</li>
                </ul>
            </section>

            <section class="upgrades">
                <h2>Delorean Upgrades</h2>
                <div class="card-collection">
                    <div class="card">
                        <div class="card-img">
                            <img src="/phpmotors/images/upgrades/flux-cap.png" alt="A flux capacitor">
                        </div>
                        <a href="/phpmotors/upgrades?q=flux-cap">Flux Capacitor</a>
                    </div>
                    <div class="card">
                        <div class="card-img">
                            <img src="/phpmotors/images/upgrades/flame.jpg" alt="flame decal">
                        </div>
                        <a href="/phpmotors/upgrades?q=decals">Flame Decals</a>
                    </div>
                    <div class="card">
                        <div class="card-img">
                            <img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt="a bumper sticker that reads 'hello world'">
                        </div>
                        <a href="/phpmotors/upgrades?q=stickers">Bumper Stickers</a>
                    </div>
                    <div class="card">
                        <div class="card-img">
                            <img src="/phpmotors/images/upgrades/hub-cap.jpg" alt="A hubcap">
                        </div>
                        <a href="/phpmotors/upgrades?q=hubcaps">Hubcaps</a>
                    </div>
                </div>
            </section>

        </div>

    </main>

    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
</body>

</html><?php unset($_SESSION['message']); ?>