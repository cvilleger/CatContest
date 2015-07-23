<?php
    require_once '../Bootstrap.php' ;
    require_once 'include/header.php';
    require_once '../repository/UserRepository.php';
?>

<body>
<div id="fb-root"></div>

    <?php require_once 'include/nav.php'; ?>
    <!--If logged-->
    <?php if(!empty($_SESSION)): ?>
    <!-- My picture -->
    <?php
        $date = new DateTime();
        echo '<h2>Ma photo pour le concours du [' . $date->format('m / Y') . ']</h2>';
    ?>
    <div id="wrapper-my-picture">
        <div id="my-picture">
            <?php
                $UserRepository = new UserRepository();
                $user = $UserRepository->getUser();
                $pictureLink = $user['pictureLink'];
                if(!empty($pictureLink)){
                    echo '<img height=250px src="' . $pictureLink . '">';
                }else{
                    echo '<img height=250px src="public/upload/empty.jpg">';
                }
            ?>
        </div>
        <div id="infos-my-picture">
            Nombre de likes :
            <?php
                $UtilService = new UtilService();
                $dateHashed = $UtilService->getCurrentHashedCode();
                $url = 'https://catcontest.herokuapp.com/maphoto.php?id=' . $user['pictureId'] . 'catcontest' . $dateHashed ; //. '&code=' . $dateHashed ;
                $res = file_get_contents('https://api.facebook.com/method/links.getStats?urls=' . $url . '&format=json');
                $resArray = json_decode($res);
                echo $resArray['0']->like_count;
            ?>
            <br>
            Classement :
            <?php
                $classement = $UserRepository->getUserClassement();
                if ($classement === false){
                    echo 'Partiper au concours pour être classer !';
                } else {
                    echo $classement . ' / ' . count($UserRepository->getUsersWithPicture());
                }
            ?>
        </div>
    </div>

    <!-- concurrent gallery -->
    <h2>Les photos du concours</h2>
    <div id="concurrent-gallery">
        <?php
            $UserRepository = new UserRepository();
            $users = $UserRepository->getUsersWithPicture();
            if(empty($users)){
                echo '<div class="important">Soyer la première personne à participer au Cat Contest de ce mois !</div>';
            }
            foreach($users as $user){
                $pictureLinkMin = $user['pictureLinkMin'];
                echo '<div class="wrapperAlbums"><img src="' . $pictureLinkMin . '">';
                echo '<div class="clear"></div>';
                echo '<div class="fb-like fb-btn" data-href="https://catcontest.herokuapp.com/maphoto.php?id=' . $user['pictureId'] . 'catcontest' . $dateHashed . '"
                    data-layout="button_count"
                    data-show-faces="true"
                    data-share="false"
                    data-colorscheme="dark"
                    ></div></div>';
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

    <!-- Wrapper winner -->
    <?php
        $UserRepository = new UserRepository();
        $userWinner = $UserRepository->getLastWinner();
    ?>
    <?php if(!empty($userWinner)): ?>
    <div id="wrapper-animal-enterprise">
        <div id="second-wrapper-animal-enterprise">
            <span id="title-enterprise">
                La dernière photo gagnante
            </span>
        </div>
    </div>
    <div class="picture">
    <?php
        echo '<img src="' . $userWinner['pictureLink'] . '">';
    ?>
    </div>
    <?php endif ?>

    <?php endif ?>

    <?php require_once 'include/footer.php'; ?>

</body>
</html>
