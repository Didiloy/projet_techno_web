<?php
namespace App\Service;
class PasswordVerificator
{
    private $common_password = ["azerty", "qwerty", "123456"];

    /**
     * Verify if the password is valid
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password) : bool
    {
        //if password is not empty
        if (!empty($password)) {
            //if password is not too short
            if (strlen($password) >= 6) {
                //if password has at least one number
                if (preg_match("#[0-9]+#", $password)) {
                    //if password has at least one letter
                    if (preg_match("#[a-zA-Z]+#", $password)) {
                        //if password is not a common password
                        if (!in_array($password, $this->common_password)) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
?>