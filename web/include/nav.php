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