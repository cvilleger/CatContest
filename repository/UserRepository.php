<?php

require_once '../service/DatabaseService.php' ;
require_once '../service/UtilService.php';

class UserRepository {

    public function __construct()
    {

    }

    /**
     * Create user if no present in database
     * @param $user_profile GraphUser
     */
    public function updateUser( $user_profile ){
        $Pdo = DatabaseService::getInstance()->getPdo();
        $facebookId = $user_profile->getId();

        $sql = 'SELECT id FROM user WHERE facebookId = :facebookId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':facebookId' => $facebookId);
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $res = $sth->fetchAll();
        //if no user in database, we create it
        if(empty($res)){
            $sql = 'INSERT INTO user (email, facebookId, firstName, gender, lastName, link,
                                      locale, name, timezone, updatedTime, verified)
                                      VALUES
                                      (:email, :facebookId, :firstName, :gender, :lastName, :link,
                                      :locale, :name, :timezone, :updatedTime, :verified)';
            $userProfileArray = $user_profile->asArray();

            $inputParameters = array(
                'email' => $userProfileArray['email'],
                'facebookId' => $userProfileArray['id'],
                'firstName' => $userProfileArray['first_name'],
                'gender' => $userProfileArray['gender'],
                'lastName' => $userProfileArray['last_name'],
                'link' => $userProfileArray['link'],
                'locale' => $userProfileArray['locale'],
                'name' => $userProfileArray['name'],
                'timezone' => $userProfileArray['timezone'],
                'updatedTime' => $userProfileArray['updated_time'],
                'verified' => $userProfileArray['verified'],
            );

            try {
                $sth = $Pdo->prepare($sql);
                $sth->execute($inputParameters);
            }catch (Exception $e){
                echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();
                die();
            }
        }
    }

    public function updateUserPicture($pictureId, $facebookPhoto){
        $FacebookAuthService = new FacebookAuthService();
        $userProfile = $FacebookAuthService->getUserProfile();
        $facebookId = $userProfile->getId();

        $UtilService = new UtilService();
        $filename = $UtilService->generateRandomToken();

        $pictureLink = $facebookPhoto['source']; //Original picture
        $pictureLinkMin = $facebookPhoto['picture']; //130px picture

        //TODO Supprimer sa previous photo
        //require allow_url_fopen
        $isUploadedpicture = copy($pictureLink, 'public/upload/' . $filename . '.jpg'); //Original picture
        $isUploadedpictureMin = copy($pictureLinkMin, 'public/upload/' . $filename . '.min.jpg'); //130px picture

        // Si mes photos ont bien été envoyé sur le server
        if($isUploadedpicture === true && $isUploadedpictureMin === true){
            //TODO unlink() previous picture et pictureMin , else return false/Exception.
        }

        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = 'UPDATE user SET pictureId = :pictureId, filename = :filename WHERE facebookId = :facebookId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':facebookId' => $facebookId, ':filename' => $filename, ':pictureId' => $pictureId);
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

        return $filename;
    }

    public function getAllUsers(){

    }

}

