<?php

class User
{

    private $id;
    private $facebookId;
    private $firstName;
    private $gender;
    private $lastName;
    private $link;
    private $locale;
    private $name;
    private $timezone;
    private $updatedTime;
    private $verified;
    private $pictureId;
    private $pictureLink;
    private $pictureLinkMin;
    private $date_win;

    /**
     * User constructor.
     * @param $facebookId
     * @param $firstName
     * @param $gender
     * @param $lastName
     * @param $link
     * @param $locale
     * @param $name
     * @param $timezone
     * @param $updatedTime
     * @param $verified
     * @param $pictureId
     * @param $pictureLink
     * @param $pictureLinkMin
     * @param $date_win
     */
    public function __construct($facebookId, $firstName, $gender, $lastName, $link, $locale, $name,$timezone,
                                $updatedTime, $verified, $pictureId = null, $pictureLink = null,
                                $pictureLinkMin = null, $date_win = null)
    {
        $this->facebookId = $facebookId;
        $this->firstName = $firstName;
        $this->gender = $gender;
        $this->lastName = $lastName;
        $this->link = $link;
        $this->locale = $locale;
        $this->name = $name;
        $this->timezone = $timezone;
        $this->updatedTime = $updatedTime;
        $this->verified = $verified;
        $this->pictureId = $pictureId;
        $this->pictureLink = $pictureLink;
        $this->pictureLinkMin = $pictureLinkMin;
        $this->date_win = $date_win;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param mixed $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return mixed
     */
    public function getUpdatedTime()
    {
        return $this->updatedTime;
    }

    /**
     * @param mixed $updatedTime
     */
    public function setUpdatedTime($updatedTime)
    {
        $this->updatedTime = $updatedTime;
    }

    /**
     * @return mixed
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * @param mixed $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    /**
     * @return null
     */
    public function getPictureId()
    {
        return $this->pictureId;
    }

    /**
     * @param null $pictureId
     */
    public function setPictureId($pictureId)
    {
        $this->pictureId = $pictureId;
    }

    /**
     * @return null
     */
    public function getPictureLink()
    {
        return $this->pictureLink;
    }

    /**
     * @param null $pictureLink
     */
    public function setPictureLink($pictureLink)
    {
        $this->pictureLink = $pictureLink;
    }

    /**
     * @return null
     */
    public function getPictureLinkMin()
    {
        return $this->pictureLinkMin;
    }

    /**
     * @param null $pictureLinkMin
     */
    public function setPictureLinkMin($pictureLinkMin)
    {
        $this->pictureLinkMin = $pictureLinkMin;
    }

    /**
     * @return null
     */
    public function getDateWin()
    {
        return $this->date_win;
    }

    /**
     * @param null $date_win
     */
    public function setDateWin($date_win)
    {
        $this->date_win = $date_win;
    }

}