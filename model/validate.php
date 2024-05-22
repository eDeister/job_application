<?php
class Validator
{
    static function validName($name): bool
    {
        //Use PHP regex to find if any characters are non-alphabetical
        return preg_match('/^[a-z]+$/i', $name);
    }

    static function validGithub($github): bool
    {
        //Validate the link using the built-in URL filter
        return (filter_var($github, FILTER_VALIDATE_URL) || empty($github));
    }

    static function validExperience($exp): bool
    {
        //Define an array of valid values, then check to see if input matches any one of them
        $years = array('0-2','2-4','4+');
        return in_array($exp, $years);
    }

    static function validPhone($phone): bool
    {
        //A rudimentary phone number validator. Returns true if the input is 10 characters long and numerical.
        return (strlen($phone) == 10 && preg_match('/^[0-9]+$/',$phone));
    }

    static function validEmail($email)
    {
        //Validate the email using the built-in email filter
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    static function validJobs($jobs)
    {
        $validJobs = DataLayer::getValidJobs();
        $invalidJobs = array();
        foreach ($jobs as $job) {
            if (!in_array($job, array_values($validJobs))) {
                $invalidJobs[] = $job;
            }
        }
        return $invalidJobs;
    }

    static function validVerticals($verticals)
    {
        $validVerticals = DataLayer::getValidVerticals();
        $invalidVerticals = array();
        foreach ($verticals as $vertical) {
            if (!in_array($vertical, array_values($validVerticals))) {
                $invalidVerticals[] = $vertical;
            }
        }
        return $invalidVerticals;
    }
}
