<?php
class Applicant
{
    private $_fname;
    private $_lname;
    private $_email;
    private $_state;
    private $_phone;
    private $_github;
    private $_experience;
    private $_relocate;
    private $_bio;

    function __construct($fname, $lname, $email, $state, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_email = $email;
        $this->_state = $state;
        $this->_phone = $phone;
    }

    public function getFname()
    {
        return $this->_fname;
    }

    public function setFname($fname): void
    {
        $this->_fname = $fname;
    }

    public function getLname()
    {
        return $this->_lname;
    }

    public function setLname($lname): void
    {
        $this->_lname = $lname;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function setEmail($email): void
    {
        $this->_email = $email;
    }

    public function getState()
    {
        return $this->_state;
    }

    public function setState($state): void
    {
        $this->_state = $state;
    }

    public function getPhone()
    {
        return $this->_phone;
    }

    public function setPhone($phone): void
    {
        $this->_phone = $phone;
    }

    public function getGithub()
    {
        return $this->_github;
    }

    public function setGithub($github): void
    {
        $this->_github = $github;
    }

    public function getExperience()
    {
        return $this->_experience;
    }

    public function setExperience($experience): void
    {
        $this->_experience = $experience;
    }

    public function getRelocate()
    {
        return $this->_relocate;
    }

    public function setRelocate($relocate): void
    {
        $this->_relocate = $relocate;
    }

    public function getBio()
    {
        return $this->_bio;
    }

    public function setBio($bio): void
    {
        $this->_bio = $bio;
    }


}