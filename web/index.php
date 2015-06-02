<?php require_once '../Bootstrap.php' ; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cat Contest</title>
    <link rel="stylesheet" href="public/css/reset-properties.css" type="text/css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" href="public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
            <?php if(empty($_SESSION)): ?>
                <li>Vous voulez participer au concours ?<a href='login.php'> Connectez-vous !</a></li>
            <?php else: ?>
                <li>Upload</li>
                <li>Mes Images</li>
            <?php endif; ?>
        </ul>
    </nav>

    <div id="facebook-profile">
        <?php
            $FacebookAuthService = new FacebookAuthService();
            $userProfile = $FacebookAuthService->getUserProfile();
            echo '<div id="header_circleGenre"><img src="//graph.facebook.com/' . $userProfile->getId() . '/picture"></div>';
            echo '<span>' . $userProfile->getName() . '</span>' ;
        ?>
        <a href='logout.php'>
            <i class="fa fa-power-off fa-2"></i>
        </a>
    </div>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="public/js/jquery.simplemodal.1.4.4.min.js"></script>
    <script src="public/js/main.js"></script>
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