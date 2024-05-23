<?php

/**
 * A class representing an applicant of a job application.
 *
 * A class representing an applicant of a job application, including first and last name, email, state, phone #,
 * a github link, years of experience, willingness to relocate, and a bio. Requires name, email, state, and phone #
 * to be instantiated, with getters and setters for all other fields.
 * @author Ethan Deister
 */
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

    /**
     * Constructs an apllicant object
     * @param String $fname First name
     * @param String $lname Last name
     * @param String $email Email address
     * @param String $state State of residence
     * @param String $phone Phone number
     */
    function __construct($fname, $lname, $email, $state, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_email = $email;
        $this->_state = $state;
        $this->_phone = $phone;
    }

    /**
     * Getters and Setters
     * Getters return the data type of the field they access,
     * meanwhile setters return void because they only accept data
     * (of the same type as what they're setting)
     */

    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @param $fname
     * @return void
     */
    public function setFname($fname): void
    {
        $this->_fname = $fname;
    }

    /**
     * @return mixed
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * @param $lname
     * @return void
     */
    public function setLname($lname): void
    {
        $this->_lname = $lname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param $email
     * @return void
     */
    public function setEmail($email): void
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @param $state
     * @return void
     */
    public function setState($state): void
    {
        $this->_state = $state;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param $phone
     * @return void
     */
    public function setPhone($phone): void
    {
        $this->_phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getGithub()
    {
        return $this->_github;
    }

    /**
     * @param $github
     * @return void
     */
    public function setGithub($github): void
    {
        $this->_github = $github;
    }

    /**
     * @return mixed
     */
    public function getExperience()
    {
        return $this->_experience;
    }

    /**
     * @param $experience
     * @return void
     */
    public function setExperience($experience): void
    {
        $this->_experience = $experience;
    }

    /**
     * @return mixed
     */
    public function getRelocate()
    {
        return $this->_relocate;
    }

    /**
     * @param $relocate
     * @return void
     */
    public function setRelocate($relocate): void
    {
        $this->_relocate = $relocate;
    }

    /**
     * @return mixed
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * @param $bio
     * @return void
     */
    public function setBio($bio): void
    {
        $this->_bio = $bio;
    }


}