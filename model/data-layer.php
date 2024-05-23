<?php

/**
 * A class with several static functions which return data.
 *
 * A class with several static functions which return verbose data that would look cluttered in the controller.
 * Includes an array of all 50 US states and a list of valid mailing lists for both jobs and verticals.
 * @author Ethan Deister
 */
class DataLayer
{
    /**
     * @return string[] Returns a string array of all 50 US states
     */
    static function getStates()
    {
        return array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado",
            "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois",
            "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts",
            "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire",
            "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma",
            "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas",
            "Utah", "Vermont", "Virginia", "West Virginia", "Wisconsin", "Wyoming"
        );
    }

    /**
     * @return string[] Returns a string array of all valid job mailing lists
     */
    static function getValidJobs()
    {
        return array(
            "js" => "JavaScript",
            "php" => "PHP",
            "java" => "Java",
            "py" => "Python",
            "html" => "HTML",
            "css" => "CSS",
            "react" => "ReactJS",
            "node" => "NodeJS"
        );
    }

    /**
     * @return string[] Returns a string array of all valid vertical mailing lists
     */
    static function getValidVerticals()
    {
        return array(
            "saas" => "SaaS",
            "health" => "Health Tech",
            "ag" => "Ag Tech",
            "hr" => "HR Tech",
            "indus" => "Industry Tech",
            "cyber" => "Cybersecurity"
        );
    }
}