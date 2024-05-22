<?php
class Controller
{
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function info()
    {
        //Set states array for dropdown option
        $this->_f3->set('SESSION.default_state', "Washington");
        $this->_f3->set('SESSION.states', array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado",
            "Connecticut", "Delaware", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois",
            "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts",
            "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire",
            "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma",
            "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas",
            "Utah", "Vermont", "Virginia", "West Virginia", "Wisconsin", "Wyoming"
        ));

        //If the form was submitted...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get data
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $state = $_POST['state'];
            $phone = $_POST['phone'];

            //Validate data
            $validName = Validator::validName($fname) && Validator::validName($lname);
            $validEmail = Validator::validEmail($email);
            $validPhone = Validator::validPhone($phone);

            //If data valid...
            if ($validName && $validEmail && $validPhone) {
                //Add data to the session
                $this->_f3->set('SESSION.fname',$fname);
                $this->_f3->set('SESSION.lname',$lname);
                $this->_f3->set('SESSION.email',$email);
                $this->_f3->set('SESSION.state',$state);
                $this->_f3->set('SESSION.phone',$phone);

                //Reroute to the next form page
                $this->_f3->reroute('experience');
                //Otherwise...
            } else {
                $this->_f3->set('SESSION.errors',null);
                $errors = array();
                //Set appropriate errors
                if(!$validName) {
                    $errors[] = 'name';
                }
                if (!$validEmail) {
                    $errors[] = 'email';
                }
                if (!$validPhone) {
                    $errors[] = 'phone';
                }
                $this->_f3->set('SESSION.errors', $errors);
            }
        }
        //Render the page
        $view = new Template();
        echo $view->render('views/personal-info.html');
    }

    function experience()
    {
        //Set session data
        $this->_f3->set('SESSION.expData', array(
            "entry" => "0-2",
            "junior" => "2-4",
            "senior" => "4+"
        ));
        $this->_f3->set('SESSION.relocData', array(
            "reloc-yes" => "Yes",
            "reloc-no" => "No",
            "reloc-maybe" => "Maybe"
        ));

        //If the form was submitted...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get data
            $bio = $_POST['bio'];
            $github = $_POST['github'];
            $exp = $_POST['years'];
            $reloc = $_POST['reloc'];

            //Validate data
            $validGithub = Validator::validGithub($github);
            $validExperience = Validator::validExperience($exp);

            //If data is valid...
            if ($validGithub && $validExperience) {
                //Add data to the session
                $this->_f3->set('SESSION.bio', $bio);
                $this->_f3->set('SESSION.github', $github);
                $this->_f3->set('SESSION.years', $exp);
                $this->_f3->set('SESSION.reloc', $reloc);
                //Reroute to the next page
                $this->_f3->reroute('mail');
                //Otherwise
            } else {
                $this->_f3->set('SESSION.errors',null);
                $errors = array();
                //Set appropriate errors
                if (!$validGithub) {
                    $errors[] = 'github';
                }
                if (!$validExperience) {
                    $errors[] = 'experience';
                }
                $this->_f3->set('SESSION.errors', $errors);
            }
        }
        //Render the page
        $view = new Template();
        echo $view->render('views/experience.html');
    }

    function mail()
    {
        $jobs = array(
            "js" => "JavaScript",
            "php" => "PHP",
            "java" => "Java",
            "py" => "Python",
            "html" => "HTML",
            "css" => "CSS",
            "react" => "ReactJS",
            "node" => "NodeJS"
        );
        $this->_f3->set('SESSION.jobs', $jobs);
        $this->_f3->set('SESSION.verticals',array(
            "saas" => "SaaS",
            "health" => "Health Tech",
            "ag" => "Ag Tech",
            "hr" => "HR Tech",
            "indus" => "Industry Tech",
            "cyber" => "Cybersecurity"
        ));
        //If the form was submitted...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get data
            $userJobs = $_POST['jobs'];
            $verticals = $_POST['verticals'];

            $jobVals = array_values($jobs);

            //Validate the data, but only if jobs were selected
            $invalidJobs = array();
            if($userJobs != null) {
                $userJobVals = array_values($userJobs);
                for ($i = 0; $i < sizeof($jobVals); $i++) {
                    //The bug is that the user only selects x amount of jobs, but there are y total,
                    //TODO: So the index gets out of sync. Find a way to validate each job alongside each selected job
                    if(!Validator::validJob($userJobVals[$i])) {
                        $invalidJobs[] = $jobVals[$i];
                    }
                }
            }
            //Clear current errors
            $this->_f3->set('SESSION.errors',null);
            //If there are no errors...
            if(empty($invalidJobs)) {
                //Add data to the session
                $this->_f3->set('SESSION.jobs',$userJobs);
                $this->_f3->set('SESSION.verticals',$verticals);

                //(If the data is valid) Reroute to the next page
                $this->_f3->reroute('summary');
            } else {
                $this->_f3->set('SESSION.userJobs',$userJobs);
                $this->_f3->set('SESSION.errors',$invalidJobs);
                echo var_dump($invalidJobs);
            }
        }
        $view = new Template();
        echo $view->render('views/mailing-list.html');
    }

    function summary()
    {
        $view = new Template();
        echo $view->render('views/summary.html');
    }
}