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

        echo '<h2>Merci de votre participation</h2>';

        echo '<img height=300px src="' . $facebookPhoto['source'] . '" title="Votre photo du Cat Contest">';
        ?>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
