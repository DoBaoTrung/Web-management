<?php
if (!defined('_INCODE')) die('Access denied...');
$data = array('pageTitle' => 'Sửa sinh viên');
requireLayout('header.php', $data);

require_once 'app/model/students.php';


$bodyArr = getBody();
// Check Step
if (empty($bodyArr['step'])) {
    /**
     * Step: Input
     */
    // Check student data does not exist
    if (!isset($_SESSION['studentEditData'])) {
        if (!empty($bodyArr['id'])) {
            $studentId = $bodyArr['id'];
            $studentQuery = getStudentByID($studentId);
            if (!empty($studentQuery)) {
                $studentEditData = array(
                    'id' => $studentQuery['id'],
                    'name' => $studentQuery['name'],
                    'description' => $studentQuery['description'],
                    'uploadPath' => 'web/avatars/student/' . $studentId . '/' . $studentQuery['avatar'],
                    'oldUploadPath' => 'web/avatars/student/' . $studentId . '/' . $studentQuery['avatar']
                );
                setSession('studentEditData', $studentEditData);
            } else {
                redirect('?module=student&action=search');
            }
        } else {
            redirect('?module=student&action=search');
        }
    }
    // Handle form submission: POST
    if (isPost()) {
        $bodyArr = getBody();
        $errorArr = array();

        // Validate name
        if (empty(trim($bodyArr['name']))) {
            $errorArr['errName'] = "Hãy nhập tên sinh viên.";
        } elseif (strlen(trim($bodyArr['name'])) > 100) {
            $errorArr['errName'] = "Không nhập quá 100 ký tự.";
        }

        // Validate description
        if (empty(trim($bodyArr['description']))) {
            $errorArr['errDescription'] = "Hãy nhập mô tả chi tiết.";
        } elseif (strlen(trim($bodyArr['description'])) > 1000) {
            $errorArr['errDescription'] = "Không nhập quá 1000 ký tự.";
        }

        // Validate avatar (file upload)
        $studentEditData = getSession('studentEditData');
        $oldPath = getOldFormData('uploadPath', $studentEditData);
        $oldPathInDB = getOldFormData('oldUploadPath', $studentEditData);
        $oldName = getOldFormData('avatar', $studentEditData);

        if (isFileChosen()) {
            if ($oldPath != $oldPathInDB) {
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $result = uploadFile($_FILES['avatar'], 'web/avatars/tmp/');
            if ($result['uploadStatus']) {
                $bodyArr['avatar'] = $result['filename'];
                $bodyArr['uploadPath'] = $result['uploadPath'];
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
                redirect('?module=student&action=edit&id=' . $studentEditData['id']);
            }
        } else {
            $bodyArr['avatar'] = $oldName;
            $bodyArr['uploadPath'] = $oldPath;
        }

        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('studentEditData', $bodyArr);
            redirect('?module=student&action=edit&step=confirm');
        } else {
            setSession('studentEditData', $bodyArr);
        }

        setSession('errorArray', $errorArr);
        redirect('?module=student&action=edit&id=' . $studentEditData['id']);
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getSession('errorArr');
    $oldBodyArr = getSession('studentEditData');
    require_once 'app/view/student_edit_input.php';
} elseif ($bodyArr['step'] == 'confirm') {
    /**
     * Step: Confirm 
     */
    // Check if URL contains &step=confirm 
    $studentEditData = getSession('studentEditData');
    unsetSession('errorArray');

    if (!empty($studentEditData) && !empty($studentEditData['token'])) {
        require_once 'app/view/student_edit_confirm.php';
    } else {
        redirect('?module=student&action=search');
    }
} elseif ($bodyArr['step'] == 'complete' && !empty($bodyArr['token'])) {
    /**
     * Step: Complete
     */
    // Check if URL contains &step=complete
    $studentEditData = getSession('studentEditData');

    if (!empty($studentEditData) && !empty($studentEditData['token'])) {
        if ($studentEditData['token'] == $bodyArr['token']) {

            $studentId = $studentEditData['id'];

            $oldUploadPath = $studentEditData['oldUploadPath'];
            $uploadPath = $studentEditData['uploadPath'];
            $pathArr = explode('/', $uploadPath);
            $filename = end($pathArr);

            $dataUpdate = array(
                'name' => $studentEditData['name'],
                'avatar' => $filename,
                'description' => $studentEditData['description'],
                'updated' => date('Y-m-d H:i:s')
            );

            $updateStatus = updateStudent($dataUpdate, $studentId);
            // If update student successfully
            if ($updateStatus) {
                if ($oldUploadPath != $uploadPath) {
                    unlink($oldUploadPath);
                    $completeDir = 'web/avatars/student/' . $studentId;
                    if (!is_dir($completeDir)) {
                        mkdir($completeDir, 0777, true);
                    }
                    $completePath = $completeDir . '/'  . $filename;
                    if (copy($uploadPath, $completePath)) {
                        unlink($uploadPath);
                        unsetSession('studentEditData');
                        require_once 'app/view/student_edit_complete.php';
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=student&action=edit&id=' . $studentId);
                    }
                } else {
                    unsetSession('studentEditData');
                    require_once 'app/view/student_edit_complete.php';
                }
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
                redirect('?module=student&action=edit&id=' . $studentId);
            }
        } else {
            redirect('?module=student&action=search');
        }
    } else {
        redirect('?module=student&action=search');
    }
}
requireLayout('footer.php');
