<?php require_once '../Bootstrap.php' ; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cat Contest</title>
    <link rel="icon" type="image/png" href="public/img/favicon.png" />
    <link rel="stylesheet" href="public/css/reset-properties.css" type="text/css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" href="public/css/cookiebanner.css" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
    <header>
        <!-- Top menu -->
        <nav>
            <ul>
                <?php if(empty($_SESSION)): ?>
                    <li>Vous voulez participer au concours ?<a href='login.php'> Connectez-vous !</a></li>
                <?php else: ?>
                    <li id="uploadActionNav">Choisir ma photo</li>
                    <li id="uploadActionNav1">Ma photo</li>
                <?php endif; ?>
            </ul>
        </nav>

        <?php if(!empty($_SESSION)) :?>
        <div id="facebook-profile">
            <?php
                $FacebookAuthService = new FacebookAuthService();
                $userProfile = $FacebookAuthService->getUserProfile();
                echo '<div id="header_circleGenre"><img src="//graph.facebook.com/' . $userProfile->getId() . '/picture"></div>';
                echo '<span>' . $userProfile->getName() . '</span>' ;
            ?>
            <a href='logout.php'>
                <i class="fa fa-power-off fa-4"></i>
            </a>
        </div>
    </header>

    <!-- Facebook Albums -->
    <div id="userFacebookAlbums">
        <i id="hideAlbumsAction" class="fa fa-times fa-2"></i>
        <div id="add-picture-from-facebook" class="wrapperAlbums">
            <a href="#wrapper-modal-window">
                <img src="public/img/envoyer-ma-photo.png" alt="Envoyer ma photo">
            </a>
        </div>
        <div class="wrapperAlbums"><img src="public/img/chat1.jpg"><span class="albumFacebookTitle">Nom album</span></div>
        <div class="wrapperAlbums"><img src="public/img/chat2.jpg"><span class="albumFacebookTitle">Nom album</span></div>
        <div class="wrapperAlbums"><img src="public/img/chat3.jpg"><span class="albumFacebookTitle">Nom album</span></div>
    </div>

    <?php endif; ?>

    <!-- Modal window -->
    <div id="wrapper-modal-window">
        <div id="content-modal-window">
            <span class="title">Où est mon image ?</span>
            <form action="#" type="POST">
                <label>Télécharger</label><br>
                <input type="file" name="file-input"><br>
                <label>Lien</label><br>
                <input type="text" name="link-input"><br>
                <button type="submit" class="button button-red" style="margin-top: 1%">Uploader</button>
            </form>
        </div>
    </div>

    <!-- My picture -->
    <div id="wrapper-my-picture">
        <div id="my-picture">
            <img src="public/img/chat1.jpg">
        </div>
        <div id="infos-my-picture">
            Titre de ma photo: mon super chat<br>
            Nombre de likes : 10<br>
        </div>
    </div>

    <!-- Header photos -->
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="public/js/jquery.simplemodal.1.4.4.min.js"></script>
    <script src="public/js/cookiebanner.js"></script>
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