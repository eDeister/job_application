<?php

/**
 * Represents an Applicant who wishes to sign up to the mailing list.
 *
 * Represents an Applicant who wishes to sign up to the maililng list, including a jobs selection array
 * and verticals selection array with respective getters and setters.
 * @author Ethan Deister
 */
class Applicant_SubscribedToLists extends Applicant
{
    private $_selectionJobs;
    private $_selectionVerticals;

    /**
     * Getters and Setters
     * Getters return the data type of the field they access,
     * meanwhile setters return void because they only accept data
     * (of the same type as what they're setting)
     */

    /**
     * @return mixed
     */
    public function getSelectionJobs()
    {
        return $this->_selectionJobs;
    }

    /**
     * @param $selectionJobs
     * @return void
     */
    public function setSelectionJobs($selectionJobs): void
    {
        $this->_selectionJobs = $selectionJobs;
    }

    /**
     * @return mixed
     */
    public function getSelectionVerticals()
    {
        return $this->_selectionVerticals;
    }

    /**
     * @param $selectionVerticals
     * @return void
     */
    public function setSelectionVerticals($selectionVerticals): void
    {
        $this->_selectionVerticals = $selectionVerticals;
    }


}