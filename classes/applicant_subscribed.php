<?php
class Applicant_SubscribedToLists extends Applicant
{
    private $_selectionJobs;
    private $_selectionVerticals;

    public function getSelectionJobs()
    {
        return $this->_selectionJobs;
    }

    public function setSelectionJobs($selectionJobs): void
    {
        $this->_selectionJobs = $selectionJobs;
    }

    public function getSelectionVerticals()
    {
        return $this->_selectionVerticals;
    }

    public function setSelectionVerticals($selectionVerticals): void
    {
        $this->_selectionVerticals = $selectionVerticals;
    }


}