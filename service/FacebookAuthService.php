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
        $this->_helper = new FacebookRedirectLoginHelper(WEBURL);
    }

    /**
     * @return string
     */
    public function getSimpleLoginUrl(){
        return $this->_helper->getLoginUrl();
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
            $loginUrl = $this->_helper->getLoginUrl($params);
            header("location: $loginUrl" );
            exit;
        }

    }

    /**
     * Get /me Facebook Request
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
     * @param $path
     * @param bool $isURL
     * @return mixed
     */
    public function postPhotoWithMsg($path, $msg, $isURL = false){
        $session = $this->getAuth('publish_actions');

        $postParam = array('message' => $msg);
        if($isURL){
            $postParam['url'] = $path;
        }else{
            $postParam['source'] = $path;
        }

        try{
            $response = (new FacebookRequest(
                $session, 'POST', '/me/photos', $postParam
            ))->execute()->getGraphObject();

            // If you're not using PHP 5.5 or later, change the file reference to:
            // 'source' => '@/path/to/file.name'

        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

        // and get Property id
        return $response;
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

    public function getFacebookAlbumPicture($album_id){
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

    public function getFacebookPhotos($album_id){
        $session = $this->getAuth('user_photos');

        try{
            $facebookRequest = (new FacebookRequest(
                $session, 'GET', '/' . $album_id . "/photos"
            ))->execute()->getGraphObject();
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $facebookAlbums = $facebookRequest->asArray();

        return $facebookAlbums['data'];
    }

}
