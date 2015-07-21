<?php
require_once '../Bootstrap.php' ;
require_once 'include/header.php';
require_once '../repository/UserRepository.php';
?>
<body>
<nav>
    <ul>
        <li>Vous voulez participer au concours ?<a href='login.php'> Connectez-vous !</a></li>
    </br>
    <div class="fb-page" data-href="https://www.facebook.com/TheCatContest" data-width="300" data-height="70" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/TheCatContest"><a href="https://www.facebook.com/TheCatContest">CatContest Community</a></blockquote></div></div>
</ul>
</nav>
<?php
    if (isset($_GET['id'])){
        $pictureId = $_GET['id'];
        $UserRepository = new UserRepository();
        $res = $UserRepository->getPictureLinkByPictureId($pictureId);
        if($res === false){
            header("location: /" );
        }
        $pictureLink = $res['pictureLink'];
        $date = new DateTime();
        $dateFormated = $date->format('Y-m'); //Current year and month
        $dateHashed = crypt($dateFormated, 'sa6546me4fgbqa+pdz@ok4p8fghsrg');

        echo '<div><img style="display: block; margin-left: auto; margin-right: auto;" height=300px src="' . $res['pictureLink'] . '" title="Votre photo du Cat Contest">';
        echo '<div class="fb-like" data-href="https://catcontest.herokuapp.com/maphoto.php?id=' . $pictureId . '&code=' . $dateHashed . '"
                    data-layout="box_count"
                    data-show-faces="true"
                    data-share="false"
                    data-colorscheme="dark"
                    ></div></div>';
    }else{
        header("location: /" );
    }
?>

<?php require_once 'include/footer.php'; ?>
</body>
</html>