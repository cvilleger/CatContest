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
        $FacebookAuthService->getFacebookPhoto($photoId);
        echo '<img src="http://graph.facebook.com/1605607462852/picture">';
        ?>

<?php else : ?>
    <?php header("location: /login.php" ); ?>
<?php endif; ?>

<?php require_once 'include/footer.php'; ?>

</body>
</html>
