<?php


    function get_authority($status) {
        switch($status) {
            case 1 :
                $status = "Administrator";
            break;
            case 2 :
                $status = "Operator";
            break;
        }

        return $status;
    }

    function get_gender($gender) {
        switch($gender) {
            case 1 :
                $gender = "Laki-Laki";
                break;
            case 2 :
                $gender = "Perempuan";
                break;
        }

        return $gender;
    }












