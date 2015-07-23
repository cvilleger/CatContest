<?php require_once 'include/header.php';
require_once '../Bootstrap.php' ?>

<body>
<?php require_once 'include/nav.php'; ?>

<?php if(!empty($_SESSION)): ?>
    <h1>Sauvegarde de votre photo</h1>

        <?php
        if(!isset($_GET['id'])){
            header("location: /" );
        }

        $photoId = $_GET['id'];
        $FacebookAuthService = new FacebookAuthService();
        $facebookPhoto = $FacebookAuthService->getFacebookPhoto($photoId);

        $UserRepository = new UserRepository();
        $UserRepository->updateUserPicture($photoId, $facebookPhoto);

        echo '<img style="display: block; margin-left: auto; margin-right: auto;" height=300px src="' . $facebookPhoto['source'] . '" title="Votre photo du Cat Contest">';

        echo '<div class="important">Merci de votre participation, redirection en cours...</div>';
        echo '</br>';

        echo '<img style="display: block; margin-left: auto; margin-right: auto; border-radius: 50%;" src="public/img/cat-loading.gif" title="Chargement de votre photo">';
        ?>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
<script type="application/javascript">
    $(function() {
        function redirectHome(){
            document.location.href = "/";
        }
        setTimeout(redirectHome, 4000);
    });
</script>
</html>
