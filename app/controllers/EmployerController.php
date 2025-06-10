<?php
session_start();
require_once __DIR__ . '/../models/Employer.php';

class EmployerController {
    private $employerModel;
    public function __construct() {
        $this->employerModel = new Employer();
    }

    public function completeProfile() {
        $error = '';
        if (!isset($_SESSION['user_id'])) {
            header('Location: /index.php?page=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($_POST['first_name'] ?? '');
            $middle_name = trim($_POST['middle_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $position = trim($_POST['position'] ?? '');
            $contact_no = trim($_POST['contact_no'] ?? '');
            $business = [
                'business_name' => trim($_POST['business_name'] ?? ''),
                'business_logo' => '',
                'business_address' => trim($_POST['business_address'] ?? ''),
                'business_type' => trim($_POST['business_type'] ?? ''),
                'business_size' => trim($_POST['business_size'] ?? ''),
                'business_desc' => trim($_POST['business_desc'] ?? ''),
                'business_email' => trim($_POST['business_email'] ?? ''),
                'business_contact' => trim($_POST['business_contact'] ?? ''),
                'business_industry' => trim($_POST['business_industry'] ?? ''),
                'business_socials' => trim($_POST['business_socials'] ?? ''),
            ];
            // Handle logo upload
            if (isset($_FILES['business_logo']) && $_FILES['business_logo']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['business_logo']['tmp_name'];
                $name = basename($_FILES['business_logo']['name']);
                $target = __DIR__ . '/../../public/assets/logos/' . $name;
                if (move_uploaded_file($tmp_name, $target)) {
                    $business['business_logo'] = '/assets/logos/' . $name;
                }
            }
            $user_id = $_SESSION['user_id'];
            $employer_id = $this->employerModel->saveProfile($user_id, $first_name, $middle_name, $last_name, $position, $contact_no);
            $this->employerModel->saveBusiness($employer_id, $business);
            header('Location: /index.php?page=employer-dashboard');
            exit;
        }
        include __DIR__ . '/../Views/pages/employer-complete-profile.php';
    }
} 