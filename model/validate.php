<?php

/**
 * The Validator class validates user input from an application form.
 *
 * The Validator class has several static methods which accept user data and return a usable error code if
 * invalid data is detected.
 * @author Ethan Deister
 */
class Validator
{
    /**
     * Function that determines if an input string is considered a valid first name (alphabetical).
     * @param String $name The first name of the applicant
     * @return bool Returns true if the applicant input any alphabetical characters
     */
    static function validName($name): bool
    {
        //Use PHP regex to find if any characters are non-alphabetical
        return preg_match('/^[a-z]+$/i', $name);
    }

    /**
     * Function that determines if an input github URL is valid based on PHP's built-in URL filter
     * @param String $github The URL being validated
     * @return bool Returns true if the applicant input any valid URL
     */
    static function validGithub($github): bool
    {
        //Validate the link using the built-in URL filter
        return (filter_var($github, FILTER_VALIDATE_URL) || empty($github));
    }

    /**
     * Function that determines if the input value of the experience checkboxes is valid
     * @param String $exp The input experience value
     * @return bool Return if the input matches any one of the valid inputs
     */
    static function validExperience($exp): bool
    {
        //Define an array of valid values, then check to see if input matches any one of them
        $years = array('0-2','2-4','4+');
        return in_array($exp, $years);
    }

    /**
     * Function that determines if the input string contains 10 numbers (a phone number) and nothing else
     * @param String $phone The input string representing a phone number input
     * @return bool Return true if the input String is ten numbers
     */
    static function validPhone($phone): bool
    {
        //A rudimentary phone number validator. Returns true if the input is 10 characters long and numerical.
        return (strlen($phone) == 10 && preg_match('/^[0-9]+$/',$phone));
    }

    /**
     * Function that determines if an input string is a valid email address using PHP's built-in email filter
     * @param String $email The email string being validated
     * @return mixed (For all practical purposes), returns false if the email is invalid
     */
    static function validEmail($email)
    {
        //Validate the email using the built-in email filter
        return filter_var($email,FILTER_VALIDATE_EMAIL);
    }

    /**
     * Function that determines if each element of an input array matches at least one element from an array of
     * valid elements.
     * @param array $jobs The input array being validated
     * @return array Return an array of any invalid inputs. Array will be empty if everything passes.
     */
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

    /**
     * Function that determines if each element of an input array matches at least one element from an array of
     * valid elements.
     * @param array $verticals The input array being validated
     * @return array Return an array of any invalid inputs. Array will be empty if everything passes.
     */
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
