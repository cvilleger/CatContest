<?php
    error_reporting(E_ALL);
    ini_set("display_error",1);

    session_start();
    require "vendor/autoload.php";
    require_once 'appsecret.php';

    use Facebook\FacebookRequest;
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;

    const APPID = "831785973542579";
    const WEBURL = "https://catcontest.herokuapp.com/";

    FacebookSession::setDefaultApplication(APPID, APPSECRET);
    $helper = new FacebookRedirectLoginHelper(WEBURL);

    if( isset($_SESSION) && isset($_SESSION['fb_token']) ){
        $session = new FacebookSession($_SESSION['fb_token']);
    } else {
        $session = $helper->getSessionFromRedirect();
    }
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>ESGI PROJECT</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<header>
    <h1>ESGI PROJECT</h1>
</header>
<?php
    if($session){
        $_SESSION['fb_token'] = (string) $session->getAccessToken();

        $request_user = new FacebookRequest($session, "GET", "/me");
        $request_user_executed = $request_user->execute();
        $user = $request_user_executed->getGraphObject(\Facebook\GraphUser::className());
        $logoutUrl = $helper->getLogoutUrl($session, WEBURL);
        echo $user->getName();
        echo "<a href='".$logoutUrl."'>Déconnection</a>";

    } else {
        $loginUrl = $helper->getLoginUrl();
        echo "<a href='".$loginUrl."'>Facebook Login</a>";
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