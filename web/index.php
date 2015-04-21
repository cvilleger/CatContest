<?php require_once '../Bootstrap.php' ; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>ESGI PROJECT</title>
</head>
<body>
<header>
    <h1>Cat Contest</h1>
</header>
<?php

$FacebookAuthService = new FacebookAuthService();
if(empty($_SESSION)){
    $loginUrl = $FacebookAuthService->getSimpleLoginUrl();
    echo "<a href='".$loginUrl."'>Facebook Login</a>";
}else{
    $userProfile = $FacebookAuthService->getUserProfileAuth();
    $username = $userProfile->getName();
    $userId = $userProfile->getId();
    echo $username . '<br>';
    ?>
        <a href='/logout.php'>Déconnection</a>
    <?php
}

?>
<footer>
    <div
        class="fb-like"
        data-share="true"
        data-width="450"
        data-show-faces="true">
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