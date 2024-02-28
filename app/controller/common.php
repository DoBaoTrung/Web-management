<?php
if (!defined('_INCODE')) die('Access denied...');

// SESSION FUNCTIONS

/**
 * This function sets a new session variable
 */
function setSession($key, $value)
{
    if (!empty(session_id())) {
        $_SESSION[$key] = $value;
        return true;
    }
    return false;
}

/**
 * This function gets all session variable values or gets a session variable value with $key
 */
function getSession($key = '')
{
    if (empty($key)) {
        return $_SESSION;
    } else {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }
    return false;
}

/**
 * This function removes all session variables or removes a session variable
 */
function unsetSession($key = '')
{
    if (empty($key)) {
        $_SESSION = array();
        return true;
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
    }
    return false;
}

/**
 * This function destroys a session
 */
function destroySession()
{
    $_SESSION = array();

    // Delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

/**
 * This function sets flash data
 */
function setFlashData($key, $value)
{
    $key = 'flash_' . $key;
    return setSession($key, $value);
}

/**
 * This function gets flash data
 */
function getFlashData($key)
{
    $key = 'flash_' . $key;
    $data = getSession($key);
    unsetSession($key);
    return $data;
}
//***************************************************************** */

/**
 * This function requires header/footer
 */
function requireLayout($filename, $data = array())
{
    $path = 'web/layouts/' . $filename;
    if (file_exists($path)) {
        require_once $path;
    }
}

/**
 * This function sends a raw HTTP header
 */
function redirect($path = 'index.php')
{
    header('Location: ' . $path);
    exit;
}

/**
 * This function checks if is get method
 */
function isGet()
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        return true;
    }
    return false;
}

/**
 * This function checks if is post method
 */
function isPost()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        return true;
    }
    return false;
}

/**
 * This function gets data from $_GET or $_POST and filters it
 */
function getBody()
{
    $bodyArr = array();

    if (isGet()) {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }

    if (isPost()) {
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $key = strip_tags($key);
                if (is_array($value)) {
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                } else {
                    $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
    }
    return $bodyArr;
}

/**
 * This function gets message to display in form if error or success
 */
function getFormMessage($msg, $msgType)
{
    if (!empty($msg)) {
        return '<div class="alert alert-' . $msgType . '">' . $msg . '</div>';
    }
    return null;
}

/**
 * This function gets error of each field
 */
function getFormError($fieldName, $errorArr)
{
    if (!empty($errorArr[$fieldName])) {
        return '<span class="error">' . reset($errorArr[$fieldName]) . '</span>';
    }
    return null;
}

/**
 * This function gets value of key in array
 */
function getOldFormData($fieldName, $bodyArr, $default = null)
{
    if (!empty($bodyArr[$fieldName])) {
        return $bodyArr[$fieldName];
    }
    return $default;
}

/**
 * This function checks if admin has logged in
 */
function isLogin()
{
    $login_id = getSession('login_id');
    $login_time = getSession('login_time');
    if (!empty($login_id) && !empty($login_time)) {
        return true;
    }
    return false;
}

/**
 * This function checks if the specified file uploaded via HTTP POST or not
 */
function isFileChosen()
{
    if (isset($_FILES['avatar']) && is_uploaded_file($_FILES['avatar']['tmp_name'])) {
        return true;
    }
    return false;
}

/**
 * This function uploads file to directory 
 */
function uploadFile($file, $dirPath)
{
    // Rename file before upload
    $filename = $file['name'];
    $filenameArr = explode('.', $filename);
    $ext = end($filenameArr);
    $newName = uniqid('avt_', true) . '.' . $ext;
    // Upload file
    $uploadPath = $dirPath . $newName;
    $uploadStatus = move_uploaded_file($file['tmp_name'], $uploadPath);

    $result = array(
        'filename' => $filename,
        'uploadPath' => $uploadPath,
        'uploadStatus' => $uploadStatus
    );
    return $result;
}
