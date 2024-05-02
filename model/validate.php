<?php

function validName($name): bool
{
    //Use PHP regex to find if any characters are non-alphabetical
    return preg_match('/&[a-z]+$/i', $name);
}

function validGithub($github): bool
{
    //Validate the link using the built-in URL filter
    return (filter_var($github, FILTER_VALIDATE_URL) || empty($github));
}

function validExperience($exp): bool
{
    //Define an array of valid values, then check to see if input matches any one of them
    $years = array('0-2','2-4','4+');
     return in_array($exp, $years);
}

function validPhone($phone): bool
{
    //A rudimentary phone number validator. Returns true if the input is 10 characters long and numerical.
    //Will be updated later to account for "1+(253)-123-4567" format. This would likely be accomplished with
    // bootstrap's input groups rather than PHP.
    return (strlen($phone) == 10 && preg_match('/^[0-9]+$/',$phone));
}

function validEmail($email)
{
    //Validate the email using the built-in email filter
    return filter_var($email,FILTER_VALIDATE_EMAIL);
}