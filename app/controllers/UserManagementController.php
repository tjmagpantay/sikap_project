<?php

require_once __DIR__ . '/../models/UserManagement.php';

class UserManagementController {
    private $model; 

    public function __construct() {
        $this->model = new UserManagement();
    }

    public function index($userType) {
        // Map user type to view file name
        $viewFile = match ($userType) {
            'jobseekers' => 'jobseeker-management.php',
            'employers'  => 'employer-management.php', // Adjust if your file is actually employers.php
            default      => $userType . '.php',
        };

        $viewPath = __DIR__ . '/../views/admin/' . $viewFile;

        // Get users by type
        $users = $this->model->getUsersByType(
            $userType === 'jobseekers' ? 'jobseeker' : 'employer'
        );

        // Check if view file exists before including
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            die("Error: View file not found: {$viewPath}");
        }
    }

    /**
     * Handle AJAX suspend/unsuspend requests
     */
    public function updateStatus() {
        // Clear any existing output buffers
        while (ob_get_level()) {
            ob_end_clean();
        }
        
        // Start fresh output buffer
        ob_start();
        
        // Set headers
        header('Content-Type: application/json');
        
        error_log("========= Status Update Request Started =========");
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . json_encode($_POST));
        error_log("Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'unknown'));
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
            ob_clean(); // Clear any output
            $this->sendJson(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        $user_id = $_POST['user_id'] ?? null;
        $action = $_POST['action'] ?? null;
        $user_type = $_POST['user_type'] ?? null;
        
        error_log("Parsed parameters:");
        error_log("user_id: " . ($user_id ?? 'null'));
        error_log("action: " . ($action ?? 'null'));
        error_log("user_type: " . ($user_type ?? 'null'));

        // Validate all required parameters
        if (!$user_id || !$action || !$user_type) {
            $this->sendJson([
                'success' => false, 
                'error' => 'Missing required parameters', 
                'received' => [
                    'user_id' => $user_id,
                    'action' => $action,
                    'user_type' => $user_type
                ]
            ]);
            return;
        }
        
        try {
            $new_status = $action === 'disable' ? 'disabled' : 'enabled';
            error_log("Attempting to update {$user_type} status: user_id={$user_id}, new_status={$new_status}");
            
            if ($user_type === 'jobseeker') {
                $success = $this->model->updateJobseekerStatus($user_id, $new_status);
            } else {
                $success = $this->model->updateEmployerStatus($user_id, $action);
            }
            
            if ($success) {
                $this->sendJson([
                    'success' => true,
                    'message' => ucfirst($action) . ' successful',
                    'new_status' => $new_status
                ]);
            } else {
                $this->sendJson([
                    'success' => false,
                    'error' => 'Failed to update status'
                ]);
            }
        } catch (Exception $e) {
            $this->sendJson([
                'success' => false,
                'error' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Utility function to send JSON responses and exit
     */
    private function sendJson($data) {
        // Clear all previous output
        ob_end_clean();
        
        // Start fresh output buffer
        ob_start();
        
        // Set headers
        header('Content-Type: application/json');
        
        // Encode response
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(['success' => false, 'error' => 'Internal server error']);
        }
        
        // Output json
        echo $json;
        
        // Send the response and end script
        ob_end_flush();
        exit;
    }

    public function exportEmployersPDF() {
        try {
            // Clear any existing output
            while (ob_get_level()) {
                ob_end_clean();
            }
            
            error_log("Starting PDF export...");
            
            if (!isset($_POST['data'])) {
                error_log("No data received in POST");
                die("Error: No data provided for PDF generation");
            }

            // Get the JSON data from POST
            $jsonData = $_POST['data'] ?? '';
            $data = json_decode($jsonData, true);
            
            if (empty($data)) {
                die("No data provided for PDF generation");
            }

        require_once __DIR__ . '/../../vendor/autoload.php';
        require_once __DIR__ . '/../../vendor/mpdf/mpdf/mpdf.php';

        // Create new PDF instance (using mPDF 6.1 syntax)
        $mpdf = new \mPDF(
            '',    // mode - default ''
            'A4',    // format - A4, for example, default ''
            0,     // font size - default 0
            '',    // default font family
            20,    // margin_left
            20,    // margin right
            20,    // margin top
            20,    // margin bottom
            15,    // margin header
            15     // margin footer
        );

        // Add title
        $mpdf->WriteHTML('
            <style>
                h1 { color: #092C4C; font-size: 24px; text-align: center; margin-bottom: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th { background-color: #092C4C; color: white; padding: 10px; text-align: left; }
                td { padding: 8px; border-bottom: 1px solid #ddd; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .status-badge {
                    padding: 4px 8px;
                    border-radius: 12px;
                    font-size: 12px;
                    display: inline-block;
                }
                .status-verified { background-color: #dcfce7; color: #166534; }
                .status-pending { background-color: #fff7ed; color: #9a3412; }
                .status-rejected { background-color: #fee2e2; color: #991b1b; }
                .status-suspended { background-color: #fef9c3; color: #854d0e; }
                .status-incomplete { background-color: #f3f4f6; color: #4b5563; }
            </style>
            <h1>Employers List</h1>
        ');

        // Start table
        $html = '
        <table>
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Representative</th>
                    <th>Status</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>';

        // Add data rows
        foreach ($data as $row) {
            // Determine status style
            $statusClass = match(strtolower($row['status'])) {
                'verified' => 'status-verified',
                'pending verification' => 'status-pending',
                'rejected' => 'status-rejected',
                'suspended' => 'status-suspended',
                'incomplete' => 'status-incomplete',
                default => ''
            };

            $html .= sprintf('
                <tr>
                    <td>%s</td>
                    <td>%s</td>
                    <td>%s</td>
                    <td><span class="status-badge %s">%s</span></td>
                    <td>%s</td>
                </tr>',
                htmlspecialchars($row['company']),
                htmlspecialchars($row['contact']),
                htmlspecialchars($row['representative']),
                $statusClass,
                htmlspecialchars($row['status']),
                htmlspecialchars($row['registered'])
            );
        }

        // Close table
        $html .= '</tbody></table>';

        // Add page footer with generation date
        $mpdf->SetFooter('Generated on ' . date('Y-m-d H:i:s') . '|Page {PAGENO}|SIKAP Employers List');

        // Write HTML content
        $mpdf->WriteHTML($html);

        // Set headers for download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="employers_list_' . date('Y-m-d') . '.pdf"');

            // Output the PDF
            $mpdf->Output('employers_list.pdf', 'I');
            exit;
        } catch (Exception $e) {
            error_log("PDF generation error: " . $e->getMessage());
            die("Error generating PDF: " . $e->getMessage());
        }
    }
}
