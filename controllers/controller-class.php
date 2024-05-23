<?php

/**
 * A class with functions which contain logic and decisions for routes to be called in the index page.
 *
 * A class with functions which contain logic and decisions for routes to be called in the index page. Includes
 * functions for a home page, the personal info page, the experience page, the mailing list page, and the summary page.
 * @author Ethan Deister
 */
class Controller
{
    private $_f3;

    /**
     * Instantiates the controller, requires a Fat-Free object
     * @param Base $f3 The F3 BASE object
     */
    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    /**
     * Renders a page for the home route. Starts a new session if the applicant has already applied once.
     * @return void
     * @throws Exception
     */
    function home()
    {
        //If the applicant has already submitted one application, allow them to resubmit another
        //by starting a new session.
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        echo var_dump($_SESSION);
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Renders a page for the info route. Calls a function from the data layer to get the list of all 50 states.
     * If form posted to itself, it validates the data and (if valid) adds it to a new Applicant object, which
     * gets added to the session. Then the page reroutes to experience.
     * @return void
     * @throws Exception
     */
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

    /**
     * Renders a page for the experience route. Sets session data for templating. If the form was posted to itself,
     * the data is validated and added to the previously defined Applicant object. Otherwise, errors are set. If data
     * was valid, it then reroutes to the next page (mailing list if signed up, otherwise the summary).
     * @return void
     * @throws Exception
     */
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
                if($app instanceof Applicant_SubscribedToLists) {
                    $this->_f3->reroute('mail');
                } else {
                    $this->_f3->reroute('summary');
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

    /**
     * Renders a page for the mailing list route. Calls data layer functions to get a list of valid jobs and
     * verticals. If the form was submitted to itself, the data is validated and added to the Applicant object and
     * the page reroutes to the summary. Otherwise, errors are set.
     * @return void
     * @throws Exception
     */
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
                $this->_f3->get('SESSION.app')->setSelectionJobs($userJobs);
                $this->_f3->get('SESSION.app')->setSelectionVerticals($userVerticals);

                //(Reroute to the next page
                $this->_f3->reroute('summary');

            //If there are errors...
            } else {
                //Set appropriate session variables
                $this->_f3->set('SESSION.errors',null);
                $this->_f3->set('SESSION.errors["jobs"]',$invalidJobs);
                $this->_f3->set('SESSION.errors["verticals"]',$invalidVerticals);
            }
        }
        $view = new Template();
        echo $view->render('views/mailing-list.html');
    }

    /**
     * Renders a page for the summary route. Sets a hive variable for conciseness. Kills the session now that the user
     * has successfully applied.
     * @return void
     * @throws Exception
     */
    function summary()
    {
        // Save applicant to F3 hive for templating, then destroy the session to avoid unwanted website behavior (e.g.
        // forms incorrectly appearing valid/invalid on second viewing if reapplying.)
        $this->_f3->set('app', $this->_f3->get('SESSION.app'));
        $view = new Template();
        echo $view->render('views/summary.html');
        session_destroy();
    }
}