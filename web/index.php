<?php require_once '../Bootstrap.php' ; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cat Contest</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" />
</head>
<body>
<header>
    <div class="content_center_header">
        <h1>Cat Contest</h1>
    </div>
</header>
<div id="content">
    <div class="content_center_body">

    <?php

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

    ?>
    </div>
</div>
<footer>
    <div class="content_center_footer">
        <p>Cat Contest 2015</p>
    </div>
</footer>
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