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
    <h2>Ma photo</h2>
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
            $date = new DateTime();
            $dateFormated = $date->format('Y-m'); //Current year and month
            $dateHashed = crypt($dateFormated, 'sa6546me4fgbqa+pdz@ok4p8fghsrg');
            $url = 'https://catcontest.herokuapp.com/maphoto.php?id=' . $user['pictureId'] ; //. '&code=' . $dateHashed ;
            $ch = curl_init(); // create curl resource
            var_dump($ch);
            curl_setopt($ch, CURLOPT_URL, 'https://api.facebook.com/method/links.getStats?urls=' . $url . '&type=json'); // set url
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string
            $output = curl_exec($ch);
            ?>
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
            $users = $UserRepository->getUsersWithPicture();
            if(empty($users)){
                echo '<h2>Soyer la première personne à participer au Cat Contest de ce mois !</h2>';
            }
            foreach($users as $user){
                $pictureLinkMin = $user['pictureLinkMin'];
                echo '<div class="wrapperAlbums"><img src="' . $pictureLinkMin . '">';
                echo '<div class="clear"></div>';
                echo '<div class="fb-like fb-btn" data-href="https://catcontest.herokuapp.com/maphoto.php?id=' . $user['pictureId'] . '"
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
