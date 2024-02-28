<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Đăng ký sinh viên');
requireLayout('header.php', $data);

require_once 'app/model/students.php';

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
            $errorArr['name']['required'] = "Hãy nhập tên sinh viên!";
        } else {
            if (strlen(trim($bodyArr['name'])) > 100) {
                $errorArr['name']['maxlength'] = "Không nhập quá 100 ký tự!";
            }
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
        $studentAddData = getSession('studentAddData');
        $oldPath = getOldFormData('uploadPath', $studentAddData);
        $oldName = getOldFormData('avatar', $studentAddData);
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
                    redirect('?module=student&action=add');
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
                    redirect('?module=student&action=add');
                }
            } else {
                $bodyArr['avatar'] = $oldName;
                $bodyArr['uploadPath'] = $oldPath;
            }
        }

        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('studentAddData', $bodyArr);

            redirect('?module=student&action=add&screen=confirm');
        } else {
            setSession('studentAddData', $bodyArr);
        }
        // Set flash-data for showing error and saving content when there is error
        setFlashData('errorArr', $errorArr);

        redirect('?module=student&action=add');
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('studentAddData');

    require_once 'app/view/student_add_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $studentAddData = getSession('studentAddData');

        if (!empty($studentAddData) && !empty($studentAddData['token'])) {
            require_once 'app/view/student_add_confirm.php';
        } else {
            redirect('?module=student&action=add');
        }
    } else {
        /**
         * Control Confirm screen
         */
        // Check if URL contains &screen=complete and contain &token=...
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $studentAddData = getSession('studentAddData');

            if (!empty($studentAddData) && !empty($studentAddData['token'])) {
                if ($studentAddData['token'] == $bodyArr['token']) {
                    $tmpPath = $studentAddData['uploadPath'];
                    $tmpPathArr = explode('/', $tmpPath);
                    $filename = end($tmpPathArr);

                    $dataInsert = array(
                        'name' => $studentAddData['name'],
                        'avatar' => $filename,
                        'description' => $studentAddData['description'],
                        'created' => date('Y-m-d H:i:s')
                    );

                    $lastInsertID = insertStudent($dataInsert);

                    // If insert subject successfully
                    if ($lastInsertID) {
                        // Make directory 'web/avatars/subject/[ID]/'
                        $completeDir = 'web/avatars/student/' . $lastInsertID;
                        if (!is_dir($completeDir)) {
                            mkdir($completeDir, 0777, true);
                        }
                        $completePath = $completeDir . '/'  . $filename;

                        // Copy to new dir and unlink
                        if (copy($tmpPath, $completePath)) {
                            unlink($tmpPath);
                            unsetSession('studentAddData');
                            require_once 'app/view/student_add_complete.php';
                        } else {
                            setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                            setFlashData('msg_type', 'danger');
                            redirect('?module=student&action=add');
                        }
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=student&action=add');
                    }
                } else {
                    redirect('?module=student&action=add');
                }
            } else {
                redirect('?module=student&action=add');
            }
        } else {
            redirect('?module=student&action=add');
        }
    }
}

requireLayout('footer.php');
