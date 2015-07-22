<?php

class UtilService
{

    /**
     * Generate a one-way string encryption with a salt and the current date(Y-m)
     * @return string
     */
    public function getCurrentHashedCode(){
        $date = new DateTime();
        $dateFormated = $date->format('Y-m'); //Current year and month
        $dateHashed = crypt($dateFormated, 'sa6546me4fgbqa+pdz@ok4p8fghsrg');
        return $dateHashed;
    }

}
