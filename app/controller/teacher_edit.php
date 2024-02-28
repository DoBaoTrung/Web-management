<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Sửa giáo viên');
requireLayout('header.php', $data);

require_once 'app/model/teachers.php';


$bodyArr = getBody(); // GET method

if (empty($bodyArr['screen'])) {
    /**
     * Control Input screen
     */
    // Get teacher-data from database
    if (!isset($_SESSION['teacherEditData'])) {
        if (!empty($bodyArr['id'])) {
            $teacherId = $bodyArr['id'];
            $teacherQuery = getTeacherByID($teacherId);

            if (!empty($teacherQuery)) {
                $teacherEditData = array(
                    'id' => $teacherId,
                    'name' => $teacherQuery['name'],
                    'specialized' => $teacherQuery['specialized'],
                    'degree' => $teacherQuery['degree'],
                    'description' => $teacherQuery['description'],
                    'uploadPath' => 'web/avatars/teacher/' . $teacherId . '/' . $teacherQuery['avatar'],
                    'oldUploadPath' => 'web/avatars/teacher/' . $teacherId . '/' . $teacherQuery['avatar']
                );
                setSession('teacherEditData', $teacherEditData);
            } else {
                redirect('?module=teacher&action=search');
            }
        } else {
            redirect('?module=teacher&action=search');
        }
    }

    // Handle form submission: POST
    if (isPost()) {

        $bodyArr = getBody(); // POST method

        $errorArr = array();

        // Validate teacher's name
        if (empty(trim($bodyArr['name']))) {
            $errorArr['name']['required'] = "Hãy nhập tên giáo viên!";
        } else {
            if (strlen(trim($bodyArr['name'])) > 100) {
                $errorArr['name']['maxlength'] = "Không nhập quá 100 ký tự!";
            }
        }

        // Validate specialized
        if (empty($bodyArr['specialized'])) {
            $errorArr['specialized']['required'] = "Hãy chọn chuyên ngành!";
        }

        // Validate degree
        if (empty($bodyArr['degree'])) {
            $errorArr['degree']['required'] = "Hãy chọn học vị!";
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
        $teacherEditData = getSession('teacherEditData');
        $oldPath = getOldFormData('uploadPath', $teacherEditData);
        $oldPathInDB = getOldFormData('oldUploadPath', $teacherEditData);
        $oldName = getOldFormData('avatar', $teacherEditData);


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
                redirect('?module=teacher&action=edit&id=' . $teacherEditData['id']);
            }
        } else {
            $bodyArr['avatar'] = $oldName;
            $bodyArr['uploadPath'] = $oldPath;
        }


        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('teacherEditData', $bodyArr);
            redirect('?module=teacher&action=edit&screen=confirm');
        } else {
            setSession('teacherEditData', $bodyArr);
        }

        // Set flash-data for showing error and saving content when there is error
        setFlashData('errorArr', $errorArr);

        redirect('?module=teacher&action=edit&id=' . $teacherEditData['id']);
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('teacherEditData');

    require_once 'app/view/teacher_edit_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $teacherEditData = getSession('teacherEditData');

        if (!empty($teacherEditData) && !empty($teacherEditData['token'])) {
            require_once 'app/view/teacher_edit_confirm.php';
        } else {
            redirect('?module=teacher&action=search');
        }
    } else {
        /**
         * Control Confirm screen
         */
        // Check if URL contains &screen=complete
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $teacherEditData = getSession('teacherEditData');

            if (!empty($teacherEditData) && !empty($teacherEditData['token'])) {
                if ($teacherEditData['token'] == $bodyArr['token']) {
                    $teacherId = $teacherEditData['id'];
                    $oldUploadPath = $teacherEditData['oldUploadPath'];
                    $uploadPath = $teacherEditData['uploadPath'];

                    $pathArr = explode('/', $uploadPath);
                    $filename = end($pathArr);

                    $dataUpdate = array(
                        'name' => $teacherEditData['name'],
                        'avatar' => $filename,
                        'description' => $teacherEditData['description'],
                        'specialized' => $teacherEditData['specialized'],
                        'degree' => $teacherEditData['degree'],
                        'updated' => date('Y-m-d H:i:s')
                    );

                    $updateStatus = updateTeacher($dataUpdate, $teacherId);

                    // If update subject successfully
                    if ($updateStatus) {
                        if ($oldUploadPath != $uploadPath) {
                            unlink($oldUploadPath);
                            $completeDir = 'web/avatars/teacher/' . $teacherId;
                            if (!is_dir($completeDir)) {
                                mkdir($completeDir, 0777, true);
                            }
                            $completePath = $completeDir . '/'  . $filename;
                            // Copy to new dir and unlink
                            if (copy($uploadPath, $completePath)) {
                                unlink($uploadPath);
                                unsetSession('teacherEditData');
                                require_once 'app/view/teacher_edit_complete.php';
                            } else {
                                setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                                setFlashData('msg_type', 'danger');
                                redirect('?module=teacher&action=edit&id=' . $teacherId);
                            }
                        } else {
                            unsetSession('teacherEditData');
                            require_once 'app/view/teacher_edit_complete.php';
                        }
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=teacher&action=edit&id=' . $teacherId);
                    }
                } else {
                    redirect('?module=teacher&action=search');
                }
            } else {
                redirect('?module=teacher&action=search');
            }
        } else {
            redirect('?module=teacher&action=search');
        }
    }
}

requireLayout('footer.php');
