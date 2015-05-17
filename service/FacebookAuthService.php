<?php

use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;

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
     * @see
     * @param $permission (public_profile, publish_actions
     * @return $session
     */
    private function getAuth($permission){
        if( isset($_SESSION) && isset($_SESSION['fb_token']) ){
            $session = new FacebookSession($_SESSION['fb_token']);
        } else {
            $session = $this->_helper->getSessionFromRedirect();
        }

        if(!$session){
            $params = array('scope' => $permission);
            $loginUrl = $this->_helper->getLoginUrl($params);
            header("location: $loginUrl" );
        }else{
            $_SESSION['fb_token'] = (string) $session->getAccessToken();
        }
        return $session;
    }

    /**
     * Get /me Facebook Request
     * @return $user_profile FacebookRequest
     */
    public function getUserProfile(){
        $session = $this->getAuth('public_profile');

        try{
            $user_profile = (new FacebookRequest(
                $session, 'GET', '/me'
            ))->execute()->getGraphObject(\Facebook\GraphUser::className());
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

        return $user_profile;
    }

    /**
     * @param $path
     * @param bool $isURL
     * @return mixed
     */
    public function postPhotoWithMsg($path, $msg, $isURL = false){
        $session = $this->getAuth('publish_actions');

        try{
            $postParam = array('message' => $msg);
            if($isURL){
                $postParam['url'] = $path;
            }else{
                $postParam['source'] = $path;
            }
            $response = (new FacebookRequest(
                $session, 'POST', '/me/photos', $postParam
            ))->execute()->getGraphObject();

            // If you're not using PHP 5.5 or later, change the file reference to:
            // 'source' => '@/path/to/file.name'

            echo "Posted with id: " . $response->getProperty('id');
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

        return $response;
    }

}