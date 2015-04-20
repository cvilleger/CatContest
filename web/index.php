<?php
    require '../Bootstrap.php' ;

    use Facebook\FacebookRequest;
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;

    FacebookSession::setDefaultApplication(FB_APPID, FB_APPSECRET);

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
</head>
<body>
<header>
    <h1>ESGI PROJECT</h1>
</header>
<?php
    if($session){
        $_SESSION['fb_token'] = (string) $session->getAccessToken();
        $logoutUrl = '/logout.php' ;
        try{
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(\Facebook\GraphUser::className());

            $user_name = $user_profile->getName();
            $user_id = $user_profile->getId();
            echo $user_profile->getName() . '<br>';
            echo "<a href='".$logoutUrl."'>Déconnection</a>";
            ?>
                <img id='user_photo' src="//graph.facebook.com/<?php echo $user_id ?>/picture?type=large">


            <?php
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
        }
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