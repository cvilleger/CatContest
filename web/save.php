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
        //$FacebookAuthService = new FacebookAuthService();
        //$facebookPhoto = $FacebookAuthService->getFacebookPhoto($photoId);
        //$facebookPhotoLink = $facebookPhoto['source'];

        $UserRepository = new UserRepository();
        $UserRepository->updateUserPictureId($photoId);

        echo '<h2>Merci de votre participation</h2>';
        ?>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
