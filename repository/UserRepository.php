<?php

require_once '../service/DatabaseService.php' ;

class UserRepository {

    function __construct()
    {

    }

    /**
     * Create user if no present
     * @param $user_profile GraphUser
     */
    public static function updateUser( $user_profile ){
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
                ':email' => $userProfileArray['email'],
                ':facebookId' => $userProfileArray['id'],
                ':firstName' => $userProfileArray['first_name'],
                ':gender' => $userProfileArray['gender'],
                ':lastName' => $userProfileArray['last_name'],
                ':link' => $userProfileArray['link'],
                ':locale' => $userProfileArray['locale'],
                ':name' => $userProfileArray['name'],
                ':timezone' => $userProfileArray['timezone'],
                ':updatedTime' => $userProfileArray['updated_time'],
                ':verified' => $userProfileArray['verified'],
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

}
