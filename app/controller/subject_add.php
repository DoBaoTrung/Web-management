<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Đăng ký môn học');
requireLayout('header.php', $data);

require_once 'app/model/subjects.php';

$bodyArr = getBody(); // GET method

if (empty($bodyArr['screen'])) {
    /**
     * Control Input screen
     */

    // Handle form submission: POST
    if (isPost()) {

        $bodyArr = getBody(); // POST method

        $errorArr = array();

        // Validate subject's name
        if (empty(trim($bodyArr['name']))) {
            $errorArr['name']['required'] = "Hãy nhập tên môn học!";
        } else {
            if (strlen(trim($bodyArr['name'])) > 100) {
                $errorArr['name']['maxlength'] = "Không nhập quá 100 ký tự!";
            }
        }

        // Validate school_year
        if (empty($bodyArr['school_year'])) {
            $errorArr['school_year']['required'] = "Hãy chọn khóa học!";
        }

        // Validate description
        if (empty(trim($bodyArr['description']))) {
            $errorArr['description']['required'] = "Hãy nhập mô tả chi tiết!";
        } else {
            if (strlen(trim($bodyArr['description'])) > 1000) {
                $errorArr['description']['maxlength'] = "Không nhập quá 1000 ký tự!";
            }
        }

        // Validate avatar (file upload)
        $subjectAddData = getSession('subjectAddData');
        $oldPath = getOldFormData('uploadPath', $subjectAddData);
        $oldName = getOldFormData('avatar', $subjectAddData);
        if (empty($oldPath)) {
            if (isFileChosen()) {
                // The first choosing
                $result = uploadFile($_FILES['avatar'], 'web/avatars/tmp/');
                if ($result['uploadStatus']) {
                    $bodyArr['avatar'] = $result['filename'];
                    $bodyArr['uploadPath'] = $result['uploadPath'];
                } else {
                    //  Set flash-data for showing message
                    setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                    redirect('?module=subject&action=add');
                }
            } else {
                $errorArr['avatar']['required'] = "Hãy chọn avatar!";
            }
        } else {
            if (isFileChosen()) {
                // Delete old file if choose a new file
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }

                $result = uploadFile($_FILES['avatar'], 'web/avatars/tmp/');
                if ($result['uploadStatus']) {
                    $bodyArr['avatar'] = $result['filename'];
                    $bodyArr['uploadPath'] = $result['uploadPath'];
                } else {
                    //  Set flash-data for showing message
                    setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                    redirect('?module=subject&action=add');
                }
            } else {
                $bodyArr['avatar'] = $oldName;
                $bodyArr['uploadPath'] = $oldPath;
            }
        }

        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('subjectAddData', $bodyArr);

            redirect('?module=subject&action=add&screen=confirm');
        } else {
            setSession('subjectAddData', $bodyArr);
        }
        // Set flash-data for showing error
        setFlashData('errorArr', $errorArr);

        redirect('?module=subject&action=add');
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('subjectAddData');

    require_once 'app/view/subject_add_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $subjectAddData = getSession('subjectAddData');

        if (!empty($subjectAddData) && !empty($subjectAddData['token'])) {
            require_once 'app/view/subject_add_confirm.php';
        } else {
            redirect('?module=subject&action=add');
        }
    } else {
        /**
         * Control Complete screen
         */
        // Check if URL contains &screen=complete
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $subjectAddData = getSession('subjectAddData');

            if (!empty($subjectAddData) && !empty($subjectAddData['token'])) {
                if ($subjectAddData['token'] == $bodyArr['token']) {
                    $tmpPath = $subjectAddData['uploadPath'];
                    $tmpPathArr = explode('/', $tmpPath);
                    $filename = end($tmpPathArr);

                    $dataInsert = array(
                        'name' => $subjectAddData['name'],
                        'avatar' => $filename,
                        'description' => $subjectAddData['description'],
                        'school_year' => $subjectAddData['school_year'],
                        'created' => date('Y-m-d H:i:s')
                    );

                    $lastInsertID = insertSubject($dataInsert);

                    // If insert subject successfully
                    if ($lastInsertID) {
                        // Make directory 'web/avatars/subject/[ID]/'
                        $completeDir = 'web/avatars/subject/' . $lastInsertID;
                        if (!is_dir($completeDir)) {
                            mkdir($completeDir, 0777, true);
                        }
                        $completePath = $completeDir . '/'  . $filename;

                        // Copy to new dir and unlink
                        if (copy($tmpPath, $completePath)) {
                            unlink($tmpPath);
                            unsetSession('subjectAddData');
                            require_once 'app/view/subject_add_complete.php';
                        } else {
                            setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                            setFlashData('msg_type', 'danger');
                            redirect('?module=subject&action=add');
                        }
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=subject&action=add');
                    }
                } else {
                    redirect('?module=subject&action=add');
                }
            } else {
                redirect('?module=subject&action=add');
            }
        } else {
            redirect('?module=subject&action=add');
        }
    }
}

requireLayout('footer.php');
