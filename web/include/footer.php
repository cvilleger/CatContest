<footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="public/js/jquery.simplemodal.1.4.4.min.js"></script>
    <script src="public/js/cookiebanner.js"></script>
    <script src="public/js/main.js"></script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '554865951320925',
                xfbml      : true,
                version    : 'v2.4',
                fileUpload : true
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4&appId=554865951320925";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
</footer>
