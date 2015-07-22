<?php
require_once '../Bootstrap.php' ;
require_once 'include/header.php';
require_once '../repository/UserRepository.php';
?>
<body>
<nav>
    <ul>
        <li><a href="index.php">Accueil</a></li>
    </br>
    <div class="fb-page" data-href="https://www.facebook.com/TheCatContest" data-width="300" data-height="70" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/TheCatContest"><a href="https://www.facebook.com/TheCatContest">CatContest Community</a></blockquote></div></div>
</ul>
</nav>
<h2>Votez pour la photo de chat du mois !</h2>
<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $res = explode('catcontest',$id);
        $pictureId = $res[0];
        $UserRepository = new UserRepository();
        $res = $UserRepository->getPictureLinkByPictureId($pictureId);
        if($res == false){
            header("location: /" );
        }
        $pictureLink = $res['pictureLink'];

        echo '<div><img style="display: block; margin-left: auto; margin-right: auto;" height=300px src="' . $res['pictureLink'] . '" title="Votre photo du Cat Contest">';
        echo '<div class="fb-like" data-href="https://catcontest.herokuapp.com/maphoto.php?id=' . $id . '"
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