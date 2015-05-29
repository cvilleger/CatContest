<?php require_once '../Bootstrap.php' ; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cat Contest</title>
    <link rel="stylesheet" href="public/css/reset-properties.css" type="text/css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
</head>
<body>
    <?php
    /*
    if(empty($_SESSION)){
        echo "<a href='/login.php'>Facebook Login</a>";
    }else{
        $FacebookAuthService = new FacebookAuthService();
        $userProfile = $FacebookAuthService->getUserProfile();
        $username = $userProfile->getName();
        $userId = $userProfile->getId();
        echo $username . '<br>';
        ?>
            <a href='/logout.php'>Déconnection</a>
        <?php
    }
    */
    ?>
    <!-- Top menu -->
    <nav>
        <ul>
            <li>Upload</li>
            <li>Mes images</li>
            <li>Déconnexion</li>
        </ul>
    </nav>

    <!-- Header -->
    <header>
        <!-- Cat rounded photo -->
        <div id="photos-header">
            <ul>
                <li><img src="public/img/cup-anti horaire.png" alt="left cup"></li>
                <li><img src="public/img/cat-logo-351.png" alt="cat logo"></li>
                <li><img src="public/img/cup-horaire.png" alt="right cup"></li>
        </div>

        <!-- Wrapper title contest -->
        <div id="wrapper-title-header">
            <p><span class ="blue-sky">Concour photo</span> en ligne ! Tentez votre chance</p>
            <span id="title-header">
                Cat Contest
            </span>
            <p>Montrez votre chat et gagnez de nombreux <span class ="blue-sky">cadeaux</span></p>
        </div>

        <!-- Wrapper title enterprise -->
        <div id="wrapper-animal-enterprise">
            <div id="second-wrapper-animal-enterprise">
                <span id="title-enterprise">
                    Animal Enterprise
                </span>
            </div>
        </div>
    </header>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '554865951320925',
            xfbml      : true,
            version    : 'v2.3'
        });
    };
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>