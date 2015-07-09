<?php
    require_once '../Bootstrap.php' ;
    require_once 'include/header.php';
    require_once '../repository/UserRepository.php';
?>

<body>
    <?php require_once 'include/nav.php'; ?>
    <!--If logged-->
    <?php if(!empty($_SESSION)): ?>
    <!-- My picture -->
    <h2>Ma photo</h2>
    <div id="wrapper-my-picture">
        <div id="my-picture">
            <?php
                $UserRepository = new UserRepository();
                $user = $UserRepository->getUser();
                echo '<img height=200px src="public/upload/' . $user['filename'] . '.jpg">';
            ?>
        </div>
        <div id="infos-my-picture">
            Titre de ma photo: mon super chat<br>
            Nombre de likes : 10<br>
        </div>
    </div>

    <!-- concurrent gallery -->
    <h2>Les photos du concours</h2>
    <div id="concurrent-gallery">
        <div class="wrapperAlbums"><img src="public/img/chat4.jpg"><span class="albumFacebookTitle">Margot Hanszechuen</span></div>
        <div class="wrapperAlbums"><img src="public/img/chat5.jpg"><span class="albumFacebookTitle">Baptiste Linel</span></div>
        <div class="wrapperAlbums"><img src="public/img/chat6.jpg"><span class="albumFacebookTitle">Christophe Villeger</span></div>
        <?php
            $UserRepository = new UserRepository();
            $users = $UserRepository->getUsers();
            foreach($users as $user){
                echo '<div class="wrapperAlbums">';
                echo '<img src="public/upload/' . $user['filename'] . '.min.jpg">';
                echo '</div>';
            }
        ?>
    </div>
    <?php endif ?>

    <!-- If not logged -->
    <?php if(empty($_SESSION)): ?>
    <!-- Header photos -->
    <div id="photos-header">
        <ul>
            <li><img src="public/img/cup-antihoraire.png" alt="left cup"></li>
            <li><img src="public/img/cat-logo-351.png" alt="cat logo"></li>
            <li><img src="public/img/cup-horaire.png" alt="right cup"></li>
        </ul>
    </div>

    <!-- Wrapper title contest -->
    <div id="wrapper-title-header">
        <p><span class ="blue-sky">Concours photo</span> en ligne ! Tentez votre chance</p>
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
    <?php endif ?>

    <?php require_once 'include/footer.php'; ?>

</body>
</html>
