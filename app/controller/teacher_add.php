<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Đăng ký giáo viên');
requireLayout('header.php', $data);

require_once 'app/model/teachers.php';


$bodyArr = getBody(); // GET method

if (empty($bodyArr['screen'])) {
    /**
     * Control Input screen
     */

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
        $teacherAddData = getSession('teacherAddData');
        $oldPath = getOldFormData('uploadPath', $teacherAddData);
        $oldName = getOldFormData('avatar', $teacherAddData);
        if (empty($oldPath)) {
            // The first choosing
            if (isFileChosen()) {
                $result = uploadFile($_FILES['avatar'], 'web/avatars/tmp/');
                // Check if upload successfully to tmp folder
                if ($result['uploadStatus']) {
                    $bodyArr['avatar'] = $result['filename'];
                    $bodyArr['uploadPath'] = $result['uploadPath'];
                } else {
                    setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                    redirect('?module=teacher&action=add');
                }
            } else {
                $errorArr['avatar']['required'] = "Hãy chọn avatar!";
            }
        } else {
            // Check if choosing a new file
            if (isFileChosen()) {
                // Delete old file 
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $result = uploadFile($_FILES['avatar'], 'web/avatars/tmp/');
                // Check if upload successfully to tmp folder
                if ($result['uploadStatus']) {
                    $bodyArr['avatar'] = $result['filename'];
                    $bodyArr['uploadPath'] = $result['uploadPath'];
                } else {
                    setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                    setFlashData('msg_type', 'danger');
                    redirect('?module=teacher&action=add');
                }
            } else {
                $bodyArr['avatar'] = $oldName;
                $bodyArr['uploadPath'] = $oldPath;
            }
        }

        // Check if not error
        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $bodyArr['token'] = $token;
            setSession('teacherAddData', $bodyArr);

            redirect('?module=teacher&action=add&screen=confirm');
        } else {
            setSession('teacherAddData', $bodyArr);
        }
        // Set flash-data for showing error 
        setFlashData('errorArr', $errorArr);

        redirect('?module=teacher&action=add');
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('teacherAddData');

    require_once 'app/view/teacher_add_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $teacherAddData = getSession('teacherAddData');

        if (!empty($teacherAddData) && !empty($teacherAddData['token'])) {
            require_once 'app/view/teacher_add_confirm.php';
        } else {
            redirect('?module=teacher&action=add');
        }
    } else {
        /**
         * Control Complete screen
         */
        // Check if URL contains &screen=complete
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $teacherAddData = getSession('teacherAddData');

            if (!empty($teacherAddData) && !empty($teacherAddData['token'])) {
                // Check if token in session equals to token in url
                if ($teacherAddData['token'] == $bodyArr['token']) {
                    $tmpPath = $teacherAddData['uploadPath'];
                    $tmpPathArr = explode('/', $tmpPath);
                    $filename = end($tmpPathArr);

                    $dataInsert = array(
                        'name' => $teacherAddData['name'],
                        'avatar' => $filename,
                        'description' => $teacherAddData['description'],
                        'specialized' => $teacherAddData['specialized'],
                        'degree' => $teacherAddData['degree'],
                        'created' => date('Y-m-d H:i:s')
                    );

                    $lastInsertID = insertTeacher($dataInsert);

                    // If insert subject successfully
                    if ($lastInsertID) {
                        // Make directory 'web/avatars/teacher/[ID]/'
                        $completeDir = 'web/avatars/teacher/' . $lastInsertID;
                        if (!is_dir($completeDir)) {
                            mkdir($completeDir, 0777, true);
                        }
                        $completePath = $completeDir . '/'  . $filename;

                        // Copy to new dir and unlink
                        if (copy($tmpPath, $completePath)) {
                            unlink($tmpPath);
                            unsetSession('teacherAddData');
                            require_once 'app/view/teacher_add_complete.php';
                        } else {
                            setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                            setFlashData('msg_type', 'danger');
                            redirect('?module=teacher&action=add');
                        }
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=teacher&action=add');
                    }
                } else {
                    redirect('?module=teacher&action=add');
                }
            } else {
                redirect('?module=teacher&action=add');
            }
        } else {
            redirect('?module=teacher&action=add');
        }
    }
}

requireLayout('footer.php');
