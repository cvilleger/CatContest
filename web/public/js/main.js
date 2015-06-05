$( document ).ready(function() {
    /**
    /* Display Facebook albums
    **/

    // Hide or show Facebook albums
    $("#userFacebookAlbums").hide();

    $("#uploadActionNav").click(function(){
        $("#userFacebookAlbums").fadeIn(400);
    });

    $("#hideAlbumsAction").click(function(){
        $("#userFacebookAlbums").fadeOut(400);
    });

    /**
     * Modal window
     */

    $("#add-picture-from-facebook").click(function(){
        $("#wrapper-modal-window").fadeIn(400);
    });
});