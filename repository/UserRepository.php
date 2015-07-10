<?php

require_once '../service/DatabaseService.php' ;

class UserRepository {

    public function __construct()
    {

    }

    public function getUser(){
        $FacebookAuthService = new FacebookAuthService();
        $userProfile = $FacebookAuthService->getUserProfile();
        $Pdo = DatabaseService::getInstance()->getPdo();
        $facebookId = $userProfile->getId();
        $sql = 'SELECT * FROM user WHERE facebookId = :facebookId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':facebookId' => $facebookId);
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $res = $sth->fetch(PDO::FETCH_ASSOC);

        return $res;
    }

    public function getUsersWithPicture(){
        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = 'SELECT * FROM user WHERE pictureId IS NOT NULL';
        try{
            $sth = $Pdo->prepare($sql);
            $sth->execute();
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $res = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $res;
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
        if (empty($res)){
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
        $pictureLink = $facebookPhoto['source']; //Original picture
        $pictureLinkMin = $facebookPhoto['picture']; //130px picture

        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = 'UPDATE user SET pictureId = :pictureId, pictureLink = :pictureLink, pictureLinkMin = :pictureLinkMin
                WHERE facebookId = :facebookId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(
                ':facebookId' => $facebookId,
                ':pictureId' => $pictureId,
                ':pictureLink' => $pictureLink,
                ':pictureLinkMin' => $pictureLinkMin
            );
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }

    }

}
