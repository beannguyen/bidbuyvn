<?php

/** Check if environment is development and display errors **/

function setReporting() {
    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}

/** Check for Magic Quotes and remove them **/

function stripSlashesDeep($value) {
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes() {
    if ( get_magic_quotes_gpc() ) {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

/** Check register globals and remove them **/

function unregisterGlobals() {
    if (ini_get('register_globals')) {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value) {
            foreach ($GLOBALS[$value] as $key => $var) {
                if ($var === $GLOBALS[$key]) {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

require(ROOT . DS . 'application' . DS . 'controllers' . DS . 'error.php');
$error = new errorController();
function error()
{
    global $error;
    $error->notFoundHandler();
    exit();
}

/** Main Call Function **/

function callHook() {

    global $url;
    $urlArray = explode("/", $url);

    // if not require to any controllers
    if (empty($urlArray[0]))
    {
        require(ROOT . DS . 'application' . DS . 'controllers' . DS . 'dashboard.php');
        $controller = new dashboardController();
        $controller->index();
        return true;
    }

    // call to a method of dashboard
    if(!file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $urlArray[0] . '.php'))
    {
        require(ROOT . DS . 'application' . DS . 'controllers' . DS . 'dashboard.php');
        $controller = new dashboardController();
        if ( method_exists( $controller, $urlArray[0] ) ) {

            $controller->{$urlArray[0]}();
            return true;
        } else {

            error();
        }
    }

    if(file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . $urlArray[0] . '.php'))
    {
        $controllers = $urlArray[0];
        require(ROOT . DS . 'application' . DS . 'controllers' . DS . $controllers . '.php');
        $className = strtolower($controllers).'Controller';
        $controller = new $className;

        array_shift($urlArray);
        if (isset($urlArray[0]) && method_exists($controller, $urlArray[0]))
        {
            if (isset($urlArray[1]))
            {
                $i = 1;
                while(isset($urlArray[$i]))
                {
                    switch ($i) {
                        case 1:
                            $agr = $urlArray[1];
                            break;
                        case 2:
                            $agr2 = $urlArray[2];
                            break;
                        case 3:
                            $agr3 = $urlArray[3];
                            break;
                    }
                    $i++;
                }

                $i--;
                switch ($i) {
                    case 1:
                        $controller->{$urlArray[0]}($agr);
                        break;
                    case 2:
                        $controller->{$urlArray[0]}($agr, $agr2);
                        break;
                    case 3:
                        $controller->{$urlArray[0]}($agr, $agr2, $agr3);
                        break;
                    default:
                        break;
                }

            } else if(!isset($urlArray[1]))
            {
                $controller->{$urlArray[0]}();
            } else
            {
                error();
            }
        } else if(!isset($urlArray[0]))
        {
            if(isset($controllers))
            {
                $controller->index();
            }
        } else
        {
            error();
        }
    } else {
        /* Error Generation Code Here */
        error();
    }
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();