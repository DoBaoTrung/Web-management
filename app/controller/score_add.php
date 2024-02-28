<?php
if (!defined('_INCODE')) die('Access denied...');

$data = array('pageTitle' => 'Nhập điểm');
requireLayout('header.php', $data);

require_once 'app/model/scores.php';
require_once 'app/model/subjects.php';
require_once 'app/model/teachers.php';
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

        // Validate student_id
        if (empty($bodyArr['student_id'])) {
            $errorArr['student_id']['required'] = "Hãy chọn sinh viên!";
        }
        // Validate subject_id
        if (empty($bodyArr['subject_id'])) {
            $errorArr['subject_id']['required'] = "Hãy chọn môn học!";
        }
        // Validate teacher_id
        if (empty($bodyArr['teacher_id'])) {
            $errorArr['teacher_id']['required'] = "Hãy chọn giáo viên!";
        }
        // Validate score
        if (empty($bodyArr['score'])) {
            $errorArr['score']['required'] = "Hãy chọn điểm!";
        }

        // Validate description
        if (empty(trim($bodyArr['description']))) {
            $errorArr['description']['required'] = "Hãy nhập nhận xét chi tiết!";
        } else {
            if (strlen(trim($bodyArr['description'])) > 1000) {
                $errorArr['description']['maxlength'] = "Không nhập quá 1000 ký tự!";
            }
        }


        if (empty($errorArr)) {
            $token = md5(uniqid() . time());
            $studentID = $bodyArr['student_id'];
            $studentQuery = getStudentByID($studentID);

            $subjectID = $bodyArr['subject_id'];
            $subjectQuery = getSubjectByID($subjectID);

            $teacherID = $bodyArr['teacher_id'];
            $teacherQuery = getTeacherByID($teacherID);

            $bodyArr['token'] = $token;
            $bodyArr['student_name'] = $studentQuery['name'];
            $bodyArr['subject_name'] = $subjectQuery['name'];
            $bodyArr['teacher_name'] = $teacherQuery['name'];

            setSession('scoreAddData', $bodyArr);

            redirect('?module=score&action=add&screen=confirm');
        } else {
            setSession('scoreAddData', $bodyArr);
        }
        // Set flash-data for showing error
        setFlashData('errorArr', $errorArr);

        redirect('?module=score&action=add');
    } // End if(isPost())

    $msg = getFlashData('msg');
    $msgType = getFlashData('msg_type');

    $errorArr = getFlashData('errorArr');
    $oldBodyArr = getSession('scoreAddData');

    $allStudentsQuery = getAllStudents();
    $allSubjectsQuery = getAllSubjects();
    $allTeachersQuery = getAllTeachers();

    require_once 'app/view/score_add_input.php';
} else {
    /**
     * Control Confirm screen
     */
    // Check if URL contains &screen=confirm 
    if ($bodyArr['screen'] == 'confirm') {
        $scoreAddData = getSession('scoreAddData');

        if (!empty($scoreAddData) && !empty($scoreAddData['token'])) {
            require_once 'app/view/score_add_confirm.php';
        } else {
            redirect('?module=score&action=add');
        }
    } else {
        /**
         * Control Complete screen
         */
        // Check if URL contains &screen=complete
        if ($bodyArr['screen'] == 'complete' && !empty($bodyArr['token'])) {
            $scoreAddData = getSession('scoreAddData');

            if (!empty($scoreAddData) && !empty($scoreAddData['token'])) {
                if ($scoreAddData['token'] == $bodyArr['token']) {

                    $dataInsert = array(
                        'student_id' => $scoreAddData['student_id'],
                        'teacher_id' => $scoreAddData['teacher_id'],
                        'subject_id' => $scoreAddData['subject_id'],
                        'score' => $scoreAddData['score'],
                        'description' => $scoreAddData['description'],
                        'created' => date('Y-m-d H:i:s')
                    );

                    $lastInsertID = insertScore($dataInsert);

                    // If insert subject successfully
                    if ($lastInsertID) {
                        $studentName = $scoreAddData['student_name'];
                        unsetSession('scoreAddData');
                        require_once 'app/view/score_add_complete.php';
                    } else {
                        setFlashData('msg', 'Hệ thống đang gặp sự cố, vui lòng thử lại sau!');
                        setFlashData('msg_type', 'danger');
                        redirect('?module=score&action=add');
                    }
                } else {
                    redirect('?module=score&action=add');
                }
            } else {
                redirect('?module=score&action=add');
            }
        } else {
            redirect('?module=score&action=add');
        }
    }
}

requireLayout('footer.php');
