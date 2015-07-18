<header>
    <!-- Top menu -->
    <nav>
        <ul>
            <?php if(empty($_SESSION)): ?>
                <li>Vous voulez participer au concours ?<a href='login.php'> Connectez-vous !</a></li>
            <?php else: ?>
                <li><a href="index.php">Accueil</a></li>
                <li id="uploadActionNav"><a href="albums.php">Choisir ma photo</a></li>
            <?php endif; ?>
            </br>
            <div class="fb-page" data-href="https://www.facebook.com/TheCatContest" data-width="300" data-height="70" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/TheCatContest"><a href="https://www.facebook.com/TheCatContest">CatContest Community</a></blockquote></div></div>
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
    <?php endif; ?>
</header>
