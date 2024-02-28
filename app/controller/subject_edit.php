<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Sửa môn học');
requireLayout('header.php', $data);

require_once 'app/model/subjects.php';

$bodyArr = getBody(); // GET method

if (empty($bodyArr['screen'])) {
    /**
     * Control Input screen
     */
    // Get subject-data from database
    if (!isset($_SESSION['subjectEditData'])) {
        if (!empty($bodyArr['id'])) {
            $subjectId = $bodyArr['id'];
            $subjectQuery = getSubjectByID($subjectId);
            if (!empty($subjectQuery)) {
                $subjectEditData = array(
                    'id' => $subjectId,
                    'name' => $subjectQuery['name'],
                    'school_year' => $subjectQuery['school_year'],
                    'description' => $subjectQuery['description'],
                    'uploadPath' => 'web/avatars/subject/' . $subjectId . '/' . $subjectQuery['avatar'],
                    'oldUploadPath' => 'web/avatars/subject/' . $subjectId . '/' . $subjectQuery['avatar']
                );
                setSession('subjectEditData', $subjectEditData);
            } else {
                redirect('?module=subject&action=search');
            }
        } else {
            redirect('?module=subject&action=search');
        }
    }

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
        $subjectEditData = getSession('subjectEditData');
        $oldPath = getOldFormData('uploadPath', $subjectEditData);
        $oldPathInDB = getOldFormData('oldUploadPath', $subjectEditData);
        $oldName = getOldFormData('avatar', $subjectEditData);

        if (isFileChosen()) {
            // Delete old file if choose a new file
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
                //  Set flash-data for showing message
                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                setFlashData('msg_type', 'danger');
                redirect('?module=subject&action=edit&id=' . $subjectEditData['id']);
            }
        } else {
            $bodyArr['avatar'] = $oldName;
            $bodyArr['uploadPath'] = $oldPath;
        }

        // Check errorArr
        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('subjectEditData', $bodyArr);
            redirect('?module=subject&action=edit&screen=confirm');
        } else {
            setSession('subjectEditData', $bodyArr);
        }

        // Set flash-data for showing error 
        setFlashData('errorArr', $errorArr);

        redirect('?module=subject&action=edit&id=' . $subjectEditData['id']);
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('subjectEditData');

    require_once 'app/view/subject_edit_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $subjectEditData = getSession('subjectEditData');

        if (!empty($subjectEditData) && !empty($subjectEditData['token'])) {
            require_once 'app/view/subject_edit_confirm.php';
        } else {
            redirect('?module=subject&action=search');
        }
    } else {
        /**
         * Control Confirm screen
         */
        // Check if URL contains &screen=complete
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $subjectEditData = getSession('subjectEditData');

            if (!empty($subjectEditData) && !empty($subjectEditData['token'])) {
                if ($subjectEditData['token'] == $bodyArr['token']) {
                    $subjectId = $subjectEditData['id'];
                    $oldUploadPath = $subjectEditData['oldUploadPath'];
                    $uploadPath = $subjectEditData['uploadPath'];

                    $pathArr = explode('/', $uploadPath);
                    $filename = end($pathArr);

                    $dataUpdate = array(
                        'name' => $subjectEditData['name'],
                        'avatar' => $filename,
                        'description' => $subjectEditData['description'],
                        'school_year' => $subjectEditData['school_year'],
                        'updated' => date('Y-m-d H:i:s')
                    );

                    $updateStatus = updateSubject($dataUpdate, $subjectId);

                    // If update subject successfully
                    if ($updateStatus) {
                        if ($oldUploadPath != $uploadPath) {
                            unlink($oldUploadPath);
                            $completeDir = 'web/avatars/subject/' . $subjectId;
                            if (!is_dir($completeDir)) {
                                mkdir($completeDir, 0777, true);
                            }
                            $completePath = $completeDir . '/'  . $filename;
                            // Copy to new dir and unlink
                            if (copy($uploadPath, $completePath)) {
                                unlink($uploadPath);
                                unsetSession('subjectEditData');
                                require_once 'app/view/subject_edit_complete.php';
                            } else {
                                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                                setFlashData('msg_type', 'danger');
                                redirect('?module=subject&action=edit&id=' . $subjectId);
                            }
                        } else {
                            unsetSession('subjectEditData');
                            require_once 'app/view/subject_edit_complete.php';
                        }
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=subject&action=edit&id=' . $subjectId);
                    }
                } else {
                    redirect('?module=subject&action=search');
                }
            } else {
                redirect('?module=subject&action=search');
            }
        } else {
            redirect('?module=subject&action=search');
        }
    }
}


requireLayout('footer.php');
