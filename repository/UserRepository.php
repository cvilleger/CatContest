<?php

require_once '../service/DatabaseService.php' ;
require_once '../service/UtilService.php';

class UserRepository {

    public function __construct()
    {

    }

    /**
     * Get the current user by asking to Facebook API
     * and deliver him from database via facebookId
     * @return array user
     */
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

    /**
     * Get all users who have a pictureId
     * @return array
     */
    public function getUsersWithPicture(){
        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = "SELECT * FROM user WHERE pictureId IS NOT NULL AND pictureId <> '' ";
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
     * Create user in DB if he is connected and not present.
     * We check that by facebookId
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

    /**
     * Update a user with a pictureId, a pictureLink and a pictureLinkMin
     * @param $pictureId
     * @param $facebookPhoto
     */
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

    /**
     * For a PicktureId, retrieve the user and deliver his PictureLink
     * @param $pictureId
     * @return mixed
     *
     */
    public function getPictureLinkByPictureId($pictureId){
        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = 'SELECT pictureLink FROM user WHERE pictureId = :pictureId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':pictureId' => $pictureId);
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Get a user by a pictureId
     * @param $pictureId
     * @return array user
     */
    public function getUserByPictureId($pictureId){
        $Pdo = DatabaseService::getInstance()->getPdo();
        $sql = 'SELECT * FROM user WHERE pictureId = :pictureId';
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':pictureId' => $pictureId);
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Return a list of array with a pictureId associated with a number of like
     * @return array(array('pictureId'=>aPictureId,'like'=>countOfLike),array(..),..)
     */
    private function getClassementWithPictureIdAndLikeCount(){
        $UtilService = new UtilService();
        $dateHashed = $UtilService->getCurrentHashedCode();

        $users = $this->getUsersWithPicture();
        $data = array();
        foreach($users as $user){
            $pictureId = $user['pictureId'];
            $url = 'https://catcontest.herokuapp.com/maphoto.php?id=' . $user['pictureId'] . 'catcontest' . $dateHashed ;
            $res = file_get_contents('https://api.facebook.com/method/links.getStats?urls=' . $url . '&format=json');
            $resArray = json_decode($res);
            $like = $resArray['0']->like_count;

            $data[] = array('pictureId' => $pictureId, 'like' => $like);
        }
        return $data;
    }

    /**
     * Return for the current user a position in the contest,
     * by sorting the getClassementWithPictureIdAndLikeCount()
     * @return bool|int
     */
    public function getUserClassement(){

        $user = $this->getUser();
        if($user['pictureId'] == false){
            return false;
        }
        $userPictureId = $user['pictureId'];

        $data = $this->getClassementWithPictureIdAndLikeCount();

        $pictureIds = array();
        $likes = array();
        // Obtient une liste de colonnes
        foreach ($data as $key => $row) {
            $pictureIds[$key]  = $row['pictureId'];
            $likes[$key] = $row['like'];
        }

        // Trie les donn�es par like DESC, pictureId DESC
        // Ajoute $data en tant que dernier param�tre, pour trier par la cl� commune
        array_multisort($likes, SORT_DESC, $pictureIds, SORT_DESC, $data);
        $position = 1;
        foreach($pictureIds as $currentPictureId){
            if ($userPictureId == $currentPictureId){
                return $position;
            }
            $position++;
        }
    }

    /**
     * Get the user who have the most like for the associated pictureId
     * @return array user
     */
    public function getUserMostLiked(){
        $data = $this->getClassementWithPictureIdAndLikeCount();

        $pictureIds = array();
        $likes = array();
        // Obtient une liste de colonnes
        foreach ($data as $key => $row) {
            $pictureIds[$key]  = $row['pictureId'];
            $likes[$key] = $row['like'];
        }

        // Trie les donn�es par like DESC, pictureId DESC
        // Ajoute $data en tant que dernier param�tre, pour trier par la cl� commune
        array_multisort($likes, SORT_DESC, $pictureIds, SORT_DESC, $data);

        if(empty($pictureIds)){
            return false;
        }

        $pictureId = $pictureIds[0];
        return $this->getUserByPictureId($pictureId);
    }

    /**
     * Update the win date (date_win) for a user to the current date
     * @see Idea: use it with a CRON at the end of the month ?
     */
    public function setUserWinner(){
        $user = $this->getUserMostLiked();
        $sql = 'UPDATE user SET date_win = :date_win WHERE id = :id';
        $date = new DateTime();
        $Pdo = DatabaseService::getInstance()->getPdo();
        try{
            $sth = $Pdo->prepare($sql);
            $inputParameters = array(':id' => $user['id'], ':date_win' => $date->format('Y-m-d H:i:s'));
            $sth->execute($inputParameters);
        }catch (Exception $e){
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
            die();
        }
    }

}
