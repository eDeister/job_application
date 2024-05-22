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
        $this->_f3->set('SESSION.states', DataLayer::getStates());

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
                //Instantiate appropriate applicant object based on mailing list preference
                if (isset($_POST['signed-up'])) {
                    $app = new Applicant_SubscribedToLists($fname,$lname,$email,$state,$phone);
                } else {
                    $app = new Applicant($fname,$lname,$email,$state,$phone);
                }

                //Add applicant  to the session
                $this->_f3->set('SESSION.app', $app);

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
                $app = $this->_f3->get('SESSION.app');
                $app->setBio($bio);
                $app->setGithub($github);
                $app->setExperience($exp);
                $app->setRelocate($reloc);
                $this->_f3->set('SESSION.app', $app);

                //Reroute to the next page based on applicant mailing list preference
                if($app instanceof Applicant) {
                    $this->_f3->reroute('summary');
                } else {
                    $this->_f3->reroute('mail');
                }

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
        //Get valid data and add it to session
        $validJobs = DataLayer::getValidJobs();
        $validVerticals = DataLayer::getValidVerticals();
        $this->_f3->set('SESSION.jobs', $validJobs);
        $this->_f3->set('SESSION.verticals', $validVerticals);

        //If the form was submitted...
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Get user data
            $userJobs = $_POST['jobs'];
            $userVerticals = $_POST['verticals'];

            //Validate jobs and verticals, but only if they were selected
            $invalidJobs = (isset($userJobs)) ? Validator::validJobs($userJobs) : null;
            $invalidVerticals = (isset($userVerticals)) ? Validator::validVerticals($userVerticals) : null;

            //Clear current errors
            $this->_f3->set('SESSION.errors',null);
            //If there are no job/vertical errors...
            if(empty($invalidJobs) && empty($invalidVerticals)) {
                //Add data to the session
                $this->_f3->get('SESSION.app')->setSelectedJobs($userJobs);
                $this->_f3->get('SESSION.app')->setSelectedVerticalss($userVerticals);

                //(Reroute to the next page
                $this->_f3->reroute('summary');

            //If there are errors...
            } else {
                //=====Note that this data is only stored to the session for the purpose of sticky forms and
                // displaying invalid data.
                //TODO:Templating and errors
                $this->_f3->set('SESSION.userJobs',$userJobs);
                $this->_f3->set('SESSION.userVerticals',$userVerticals);
                $this->_f3->set('SESSION.errors',array($invalidJobs,$invalidVerticals));
                echo var_dump($invalidJobs);
            }
        }
        $view = new Template();
        echo $view->render('views/mailing-list.html');
    }

    function summary()
    {
        // Save applicant to F3 hive for templating, then destroy the session to avoid unwanted website behavior (e.g.
        // forms incorrectly appearing valid/invalid on second viewing if reapplying.)
        $this->_f3->set('app', $this->_f3->get('SESSION.app'));
        session_destroy();
        $view = new Template();
        echo $view->render('views/summary.html');
    }
}