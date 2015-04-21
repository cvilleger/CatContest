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
     * Get /me Facebook Request
     * @return $user_profile FacebookRequest
     */
    public function getUserProfileAuth(){
        $helper = $this->_helper;

        if( isset($_SESSION) && isset($_SESSION['fb_token']) ){
            $session = new FacebookSession($_SESSION['fb_token']);
        } else {
            $session = $helper->getSessionFromRedirect();
        }

        if($session){
            $_SESSION['fb_token'] = (string) $session->getAccessToken();
            try{
                $user_profile = (new FacebookRequest(
                    $session, 'GET', '/me'
                ))->execute()->getGraphObject(\Facebook\GraphUser::className());
            } catch(FacebookRequestException $e) {
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
                die();
            }
        } else {
            $loginUrl = $helper->getLoginUrl();
            header("location: $loginUrl" );
        }
        return $user_profile;
    }

    /**
     * @param $path
     * @param bool $isURL
     * @return mixed
     */
    public function photoAuthAndPost($path, $isURL = false){
        $helper = $this->_helper;

        if( isset($_SESSION) && isset($_SESSION['fb_token']) ){
            $session = new FacebookSession($_SESSION['fb_token']);
        } else {
            $session = $helper->getSessionFromRedirect();
        }

        if($session){
            $_SESSION['fb_token'] = (string) $session->getAccessToken();
            try{
                $postParam = array('message' => 'Ma photo du Cat Contest 2015');
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
        } else {
            $params = array('scope' => 'publish_actions');
            $loginUrl = $helper->getLoginUrl($params);
            header("location: $loginUrl" );
        }
        return $response;
    }

}