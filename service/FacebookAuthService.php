<?php

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

require_once '../repository/UserRepository.php';

/**
 * Class FacebookAuthService
 */
class FacebookAuthService {
    private $_helper;

    function __construct(){
        FacebookSession::setDefaultApplication(FB_APPID, FB_APPSECRET);
        $this->_helper = new FacebookRedirectLoginHelper(WEBURL); // Default redirect at homepage
    }

    /**
     * Get the base login with the email permission
     * @return string
     */
    public function getSimpleLoginUrl(){
        return $this->getAuth('email');
    }

    /**
     * Get Auth for a certain permission
     * @param $permission (public_profile, publish_actions
     * @return $session
     */
    private function getAuth($permission){
        if( isset($_SESSION) && isset($_SESSION['fb_token']) ){
            $session = new FacebookSession($_SESSION['fb_token']);
        } else {
            $session = $this->_helper->getSessionFromRedirect();
        }

        //If first time (or session cleared)
        if(!$session){
            $params = array('scope' => $permission);
            $loginUrl = $this->_helper->getLoginUrl($params);
            header("location: $loginUrl" );
            exit;
        }

        //if invalide accessToken
        if(!$session->getAccessToken()->isValid(FB_APPID, FB_APPSECRET)){
            unset($_SESSION['fb_token']);
            header("location: /" );
            exit;
        }

        //Set a long lived access token.
        $session->getAccessToken()->extend(FB_APPID, FB_APPSECRET);

        //We set the valid and long lived facebook token to the session
        $_SESSION['fb_token'] = (string) $session->getAccessToken();

        //Get list of permissions from Facebook
        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/me/permissions'
            ))->execute()->getGraphObject(\Facebook\GraphObject::className());
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
        }

        //For certain permission like 'email', we asking sometime in fact 'public_profile' (by default) and 'email'.
        $permissionsArray = $facebookRequest->asArray();

        $isFacebookGranted = false;
        foreach($permissionsArray as $permStatus){
            if($permStatus->permission == $permission){
                //Asked permission at least once
                if($permStatus->status == 'granted'){
                    $isFacebookGranted = true;
                    break;
                } else {
                    //User declined Facebook permission at least once
                    $params = array('scope' => $permission);
                    $reLoginUrl = $this->_helper->getReRequestUrl($params); //Ask for reRequest
                    header('location: ' . $reLoginUrl);
                    exit;
                }
            }
        }

        if($isFacebookGranted){
            return $session;
        } else {
            //User have not been asked for this permission
            $params = array('scope' => $permission);

            //Special case for user_photos, we redirect to
            if($permission == 'user_photos'){
                $helper = new FacebookRedirectLoginHelper(WEBURL . 'albums.php');
                $loginUrl = $helper->getLoginUrl($params);
            }else{
                $loginUrl = $this->_helper->getLoginUrl($params);
            }
            echo '<script language="Javascript">document.location.replace("' . $loginUrl . '")</script>';
            exit;
        }

    }

    /**
     * Get /me Facebook Request and create user is not in DB
     * @return $user_profile FacebookRequest
     */
    public function getUserProfile(){
        $session = $this->getAuth('email');

        try{
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(\Facebook\GraphUser::className());
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

        $userRepository = new UserRepository();
        $userRepository->updateUser($user_profile);

        return $user_profile;
    }

    /**
     * Get all Facebook Albums
     * With this struct : array( array('Infos' => $album, 'Photos' => $Photos),array(...),... )
     * @return FacebookRequest as Array()
     */
    public function getFacebookAlbums(){
        $session = $this->getAuth('user_photos');

        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/me/albums'
            ))->execute()->getGraphObject(\Facebook\GraphAlbum::className());
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $facebookAlbums = $facebookRequest->asArray()['data'];

        return $facebookAlbums;
    }

    /**
     * @param Get the FacebookObject for the current album_id;
     * @return mixed
     */
    public function getFacebookAlbum($album_id){
        $session = $this->getAuth('user_photos');

        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/'.$album_id //."/picture?redirect=false"
            ))->execute()->getGraphObject(\Facebook\GraphObject::className());
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $facebookAlbums = $facebookRequest->asArray();

        return $facebookAlbums;
    }

    /*
     * Get the all FacebookObject photos for a album_id
     */
    public function getFacebookPhotos($album_id){
        $session = $this->getAuth('user_photos');

        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/' . $album_id . "/photos"
            ))->execute()->getGraphObject();
        } catch(FacebookRequestException $e) {
            header("location: /" );
        }
        $facebookPhotos = $facebookRequest->asArray();

        return $facebookPhotos['data'];
    }

    /*
     * get the FacebookObject photo for a photo_iD
     */
    public function getFacebookPhoto($photoId){
        $session = $this->getAuth('user_photos');

        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/' . $photoId
            ))->execute()->getGraphObject();
        } catch(FacebookRequestException $e) {
            header("location: /" );
        }
        $facebookPhoto = $facebookRequest->asArray();

        return $facebookPhoto;
    }

}
