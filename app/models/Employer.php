<?php
// filepath: c:\xampp\htdocs\sikap\app\models\Employer.php
require_once __DIR__ . '/../../config/sikap_db.php';

class Employer
{
    private $db;
    private $table_name = "employer";

    const STATUS_INCOMPLETE = 'incomplete';
    const STATUS_PENDING_VERIFICATION = 'pending_verification';
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SUSPENDED = 'suspended';

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/sikap_db.php';
        try {
            $this->db = new PDO(
                "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_pass']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function findByUserId($user_id)
    {
        try {
            $sql = "SELECT * FROM employer WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['user_id' => $user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding employer by user ID: ' . $e->getMessage());
            return false;
        }
    }

    public function getBusiness($employer_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM employers_business WHERE employer_id = ? LIMIT 1");
        $stmt->execute([$employer_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkBusinessCompletion($employer_id)
    {
        try {
            // Get employer data
            $employer = $this->findById($employer_id);
            if (!$employer) {
                return false;
            }

            // Check personal profile completion (4 required fields)
            $personalCompleted = !empty($employer['first_name']) &&
                !empty($employer['last_name']) &&
                !empty($employer['position']) &&
                !empty($employer['contact_no']);

            // Get business data
            $business = $this->getBusiness($employer_id);
            if (!$business) {
                return false;
            }

            // Check business profile completion (8 required fields)
            $businessCompleted = !empty($business['business_name']) &&
                !empty($business['business_desc']) &&
                !empty($business['business_type']) &&
                !empty($business['business_industry']) &&
                !empty($business['business_address']) &&
                !empty($business['business_contact']) &&
                !empty($business['business_team_size']) &&
                !empty($business['business_established_year']);

            // Check all 9 required documents
            $documents = $this->getDocuments($employer_id);
            $requiredDocuments = [
                'letter_of_intent',
                'company_profile',
                'business_permit',
                'cert_of_no_pending_case',
                'dole_registration',
                'cert_no_objection',
                'poea_reg',
                'job_vaccancies_qual',
                'phil_jobnet_reg'
            ];

            $allDocumentsUploaded = true;
            foreach ($requiredDocuments as $docType) {
                if (empty($documents[$docType])) {
                    $allDocumentsUploaded = false;
                    break;
                }
            }

            return $personalCompleted && $businessCompleted && $allDocumentsUploaded;
        } catch (Exception $e) {
            error_log('Error checking business completion: ' . $e->getMessage());
            return false;
        }
    }

    public function updateBusinessCompletionStatus($employer_id)
    {
        try {
            $isCompleted = $this->checkBusinessCompletion($employer_id) ? 1 : 0;

            $sql = "UPDATE employers_business SET business_completed = ? WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$isCompleted, $employer_id]);

            return $result;
        } catch (PDOException $e) {
            error_log('Error updating business completion status: ' . $e->getMessage());
            return false;
        }
    }

    public function updateEmployerCompletionStatus($employer_id)
    {
        try {
            $employer = $this->findById($employer_id);
            if (!$employer) {
                return false;
            }

            // Check if employer profile is completed
            $isCompleted = !empty($employer['first_name']) &&
                !empty($employer['last_name']) &&
                !empty($employer['contact_no']) &&
                !empty($employer['company_name']) ? 1 : 0;

            $sql = "UPDATE employer SET profile_completed = ? WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$isCompleted, $employer_id]);

            return $result;
        } catch (PDOException $e) {
            error_log('Error updating employer completion status: ' . $e->getMessage());
            return false;
        }
    }

    public function findById($employer_id)
    {
        try {
            $sql = "SELECT * FROM employer WHERE employer_id = :employer_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['employer_id' => $employer_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error finding employer by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function getDocuments($employer_id)
    {
        try {

            // Get the document record for this employer
            $stmt = $this->db->prepare("SELECT * FROM employer_documents WHERE employer_id = ? LIMIT 1");
            $stmt->execute([$employer_id]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$record) {
                return [];
            }


            // Extract document paths from the columns
            $documents = [];
            $documentColumns = [
                'letter_of_intent',
                'company_profile',
                'business_permit',
                'cert_of_no_pending_case',
                'dole_registration',
                'cert_no_objection',
                'poea_reg',
                'job_vaccancies_qual',
                'phil_jobnet_reg'
            ];

            foreach ($documentColumns as $column) {
                if (isset($record[$column]) && !empty($record[$column])) {
                    $documents[$column] = $record[$column];
                }
            }

            return $documents;
        } catch (PDOException $e) {
            error_log('Error getting documents: ' . $e->getMessage());
            error_log('PDO Error Info: ' . print_r($e->errorInfo ?? [], true));
            return [];
        }
    }

    public function calculateProfileCompletion($user_id)
    {
        $employer = $this->findByUserId($user_id);
        if (!$employer) {
            return 0;
        }

        $totalItems = 0;
        $completedItems = 0;

        // 1. Personal Information (4 required fields)
        $personalFields = ['first_name', 'last_name', 'position', 'contact_no'];
        foreach ($personalFields as $field) {
            $totalItems++;
            if (!empty($employer[$field])) {
                $completedItems++;
            }
        }

        // 2. Business Information (6 required fields)
        $business = $this->getBusiness($employer['employer_id']);
        if ($business) {
            $businessFields = [
                'business_name',
                'business_desc',
                'business_type',
                'business_industry',
                'business_address',
                'business_contact',
                'business_team_size',
                'business_established_year'
            ];

            foreach ($businessFields as $field) {
                $totalItems++;
                if (!empty($business[$field])) {
                    $completedItems++;
                }
            }
        } else {
            // If no business record exists, count all business fields as incomplete
            $totalItems += 8;
        }

        // 3. Required Documents (9 documents)
        $documents = $this->getDocuments($employer['employer_id']);
        $requiredDocuments = [
            'letter_of_intent',
            'company_profile',
            'business_permit',
            'cert_of_no_pending_case',
            'dole_registration',
            'cert_no_objection',
            'poea_reg',
            'job_vaccancies_qual',
            'phil_jobnet_reg'
        ];

        foreach ($requiredDocuments as $docType) {
            $totalItems++;
            if (!empty($documents[$docType])) {
                $completedItems++;
            }
        }

        // Note: Social media is NOT counted as it's optional

        return $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
    }

    public function isVerified($user_id)
    {
        try {
            $employer = $this->findByUserId($user_id);
            if (!$employer) {
                return false;
            }

            // Check if employer status is 'verified' 
            if ($employer['status'] === self::STATUS_VERIFIED) {
                return true;
            }

            // Also check accreditation table for approved status
            $sql = "SELECT a.status 
                    FROM accreditation a 
                    WHERE a.employer_id = ? AND a.status = 'approved'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer['employer_id']]);
            $accreditation = $stmt->fetch();

            return $accreditation !== false;
        } catch (PDOException $e) {
            error_log('Error checking verification status: ' . $e->getMessage());
            return false;
        }
    }

    public function canPostJobs($user_id)
    {
        $employer = $this->findByUserId($user_id);
        if (!$employer) {
            return false;
        }

        // Check if employer is verified and profile is completed
        $verificationStatus = $this->getVerificationStatus($user_id);
        $isVerified = $verificationStatus['status'] === 'verified';
        $profileCompleted = !empty($employer['profile_completed']) && $employer['profile_completed'] == 1;

        return $isVerified && $profileCompleted;
    }

    public function updateProfilePhoto($user_id, $photo_path)
    {
        $stmt = $this->db->prepare("UPDATE " . $this->table_name . " SET profile_photo = ? WHERE user_id = ?");
        return $stmt->execute([$photo_path, $user_id]);
    }

    public function create($user_id, $first_name, $last_name, $position, $contact_no, $middle_name = null, $company_name = null, $about_us = null)
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO employer (user_id, first_name, middle_name, last_name, position, contact_no, company_name, about_us, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $result = $stmt->execute([$user_id, $first_name, $middle_name, $last_name, $position, $contact_no, $company_name, $about_us]);

            if ($result) {
                // Return the employer_id instead of just true
                $employer_id = $this->db->lastInsertId();
                return $employer_id;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log('Error creating employer profile: ' . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($user_id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE " . $this->table_name . " 
            SET first_name = ?, middle_name = ?, last_name = ?, position = ?, contact_no = ?, company_name = ?, about_us = ?, updated_at = NOW() 
            WHERE user_id = ?
        ");
        $result = $stmt->execute([
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['position'],
            $data['contact_no'],
            $data['company_name'],
            $data['about_us'],
            $user_id
        ]);

        // Update completion status after profile update
        if ($result) {
            $employer = $this->findByUserId($user_id);
            if ($employer) {
                $this->updateEmployerCompletionStatus($employer['employer_id']);
                $this->updateBusinessCompletionStatus($employer['employer_id']);
            }
        }

        return $result;
    }

    public function createOrUpdateProfile($user_id, $data)
    {
        $existing = $this->findByUserId($user_id);

        if ($existing) {
            return $this->updateProfile($user_id, $data);
        } else {
            return $this->create(
                $user_id,
                $data['first_name'],
                $data['last_name'],
                $data['position'],
                $data['contact_no'],
                $data['middle_name'],
                $data['company_name'],
                $data['about_us']
            );
        }
    }

    public function createOrUpdateBusiness($employer_id, $data)
    {
        $existing = $this->getBusiness($employer_id);

        if ($existing) {
            $result = $this->updateBusiness($employer_id, $data);
        } else {
            $result = $this->createBusiness($employer_id, $data);
        }

        // Update completion status after create/update
        if ($result) {
            $this->updateBusinessCompletionStatus($employer_id);
        }

        return $result;
    }

    public function createBusiness($employer_id, $data)
    {
        $fields = ['employer_id'];
        $values = [$employer_id];
        $placeholders = ['?'];

        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = $value;
            $placeholders[] = '?';
        }

        $fields[] = 'created_at';
        $fields[] = 'updated_at';
        $placeholders[] = 'NOW()';
        $placeholders[] = 'NOW()';

        $sql = "INSERT INTO employers_business (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    public function updateBusiness($employer_id, $data)
    {
        if (empty($data)) {
            return true;
        }

        $fields = [];
        $values = [];

        foreach ($data as $field => $value) {
            $fields[] = "$field = ?";
            $values[] = $value;
        }

        $fields[] = "updated_at = NOW()";
        $values[] = $employer_id;

        $sql = "UPDATE employers_business SET " . implode(', ', $fields) . " WHERE employer_id = ?";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    public function saveDocument($employer_id, $document_type, $file_path, $original_filename = null, $file_size = null)
    {
        try {
            // Define allowed document types for security (match your table columns)
            $allowedTypes = [
                'letter_of_intent',
                'company_profile',
                'business_permit',
                'cert_of_no_pending_case',
                'dole_registration',
                'cert_no_objection',
                'poea_reg',
                'job_vaccancies_qual',
                'phil_jobnet_reg'
            ];

            if (!in_array($document_type, $allowedTypes)) {
                return false;
            }

            // Check if a record exists for this employer
            $sql = "SELECT req_doc_id FROM employer_documents WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            $existing = $stmt->fetch();

            if ($existing) {
                // Update existing record - use backticks for column names
                $sql = "UPDATE employer_documents SET `{$document_type}` = ?, upload_date = NOW() WHERE employer_id = ?";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$file_path, $employer_id]);
            } else {
                // Insert new record - create new row with this document
                $sql = "INSERT INTO employer_documents (employer_id, `{$document_type}`, upload_date) VALUES (?, ?, NOW())";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$employer_id, $file_path]);
            }

            if (!$result) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            error_log('Error saving document: ' . $e->getMessage());
            error_log('SQL Error Info: ' . print_r($e->errorInfo ?? [], true));
            return false;
        }
    }

    public function createProfile($data)
    {
        try {
            $sql = "INSERT INTO employer (user_id, first_name, middle_name, last_name, position, contact_no, company_name, about_us, created_at) 
                    VALUES (:user_id, :first_name, :middle_name, :last_name, :position, :contact_no, :company_name, :about_us, NOW())";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log('Error creating employer profile: ' . $e->getMessage());
            return false;
        }
    }

    public function markProfileCompleted($employer_id)
    {
        try {
            $sql = "UPDATE employer SET 
                    profile_completed = 1, 
                    status = :status, 
                    updated_at = CURRENT_TIMESTAMP 
                WHERE employer_id = :employer_id";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                'employer_id' => $employer_id,
                'status' => self::STATUS_PENDING_VERIFICATION
            ]);

            if ($result) {
                $accreditationId = $this->createAccreditationRecord($employer_id);

                // ADDED: Send notification to admins about new accreditation request
                if ($accreditationId) {
                    try {
                        require_once __DIR__ . '/../services/NotificationService.php';
                        require_once __DIR__ . '/../../config/sikap_db.php';

                        $config = require __DIR__ . '/../../config/sikap_db.php';
                        $notificationPdo = new PDO(
                            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
                            $config['db_user'],
                            $config['db_pass']
                        );
                        $notificationPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $notificationService = new NotificationService($notificationPdo);

                        // Get employer details for notification
                        $employer = $this->findById($employer_id);
                        $business = $this->getBusiness($employer_id);

                        $employerName = trim($employer['first_name'] . ' ' . $employer['last_name']);
                        $businessName = $business['business_name'] ?? $employer['company_name'] ?? 'Unknown Business';
                        $businessType = $business['business_type'] ?? null;

                        // Send notification to admins
                        $notificationResult = $notificationService->notifyAdminsAboutNewAccreditation(
                            $accreditationId,
                            $employerName,
                            $businessName,
                            $businessType
                        );

                        if ($notificationResult) {
                            error_log("Accreditation request notification sent to admins for accreditation ID: $accreditationId");
                        } else {
                            error_log("Failed to send accreditation request notification for accreditation ID: $accreditationId");
                        }
                    } catch (Exception $e) {
                        error_log("Error sending accreditation request notification: " . $e->getMessage());
                        // Don't fail the profile completion if notification fails
                    }
                }

                // Update business completion status
                $this->updateBusinessCompletionStatus($employer_id);
            }

            return $result;
        } catch (PDOException $e) {
            error_log('Error marking profile as completed: ' . $e->getMessage());
            return false;
        }
    }

    private function createAccreditationRecord($employer_id)
    {
        try {
            // Check if accreditation record already exists
            $checkSql = "SELECT accreditation_id FROM accreditation WHERE employer_id = ?";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([$employer_id]);
            $existing = $checkStmt->fetch();

            if (!$existing) {
                // Create new accreditation record
                $sql = "INSERT INTO accreditation (employer_id, status, created_at) VALUES (?, 'pending', NOW())";
                $stmt = $this->db->prepare($sql);
                $result = $stmt->execute([$employer_id]);

                if ($result) {
                    $accreditationId = $this->db->lastInsertId();
                    return $accreditationId;
                }
            } else {
                return $existing['accreditation_id'];
            }

            return false;
        } catch (PDOException $e) {
            error_log('Error creating accreditation record: ' . $e->getMessage());
            return false;
        }
    }

    public function getVerificationStatus($user_id)
    {
        try {
            $employer = $this->findByUserId($user_id);
            if (!$employer) {
                return ['status' => 'not_found', 'message' => 'Employer not found'];
            }

            // Check accreditation status
            $sql = "SELECT status, reviewed_at, notes 
                    FROM accreditation 
                    WHERE employer_id = ? 
                    ORDER BY created_at DESC 
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer['employer_id']]);
            $accreditation = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$accreditation) {
                return [
                    'status' => 'pending_submission',
                    'message' => 'Complete your profile to submit for verification'
                ];
            }

            switch ($accreditation['status']) {
                case 'approved':
                    return [
                        'status' => 'verified',
                        'message' => 'Your employer account has been verified',
                        'verified_at' => $accreditation['reviewed_at']
                    ];
                case 'rejected':
                    return [
                        'status' => 'rejected',
                        'message' => 'Your application was rejected',
                        'reason' => $accreditation['notes']
                    ];
                case 'pending':
                default:
                    return [
                        'status' => 'pending',
                        'message' => 'Your application is under review'
                    ];
            }
        } catch (PDOException $e) {
            error_log('Error getting verification status: ' . $e->getMessage());
            return ['status' => 'error', 'message' => 'Unable to check status'];
        }
    }

    public function getPendingAccreditations()
    {
        try {
            $sql = "SELECT 
                        ea.accreditation_id,
                        ea.employer_id,
                        ea.status,
                        ea.created_at,
                        ea.reviewed_at,
                        ea.notes,
                        u.email,
                        e.first_name,
                        e.last_name,
                        e.position,
                        e.contact_no,
                        eb.business_name,
                        eb.company_name,
                        eb.business_type,
                        eb.business_industry,
                        eb.business_team_size,
                        eb.business_desc,
                        eb.business_address,
                        admin.full_name as reviewed_by_name
                    FROM employer_accreditations ea
                    JOIN employers e ON ea.employer_id = e.employer_id
                    JOIN users u ON e.user_id = u.user_id
                    LEFT JOIN employer_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN admins admin ON ea.reviewed_by = admin.admin_id
                    WHERE ea.status = 'pending'
                    ORDER BY ea.created_at ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting pending accreditations: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllAccreditations()
    {
        try {
            $sql = "SELECT 
                        ea.accreditation_id,
                        ea.employer_id,
                        ea.status,
                        ea.created_at,
                        ea.reviewed_at,
                        ea.notes,
                        u.email,
                        e.first_name,
                        e.last_name,
                        e.position,
                        e.contact_no,
                        eb.business_name,
                        eb.company_name,
                        eb.business_type,
                        eb.business_industry,
                        eb.business_team_size,
                        eb.business_desc,
                        eb.business_address,
                        admin.full_name as reviewed_by_name
                    FROM employer_accreditations ea
                    JOIN employers e ON ea.employer_id = e.employer_id
                    JOIN users u ON e.user_id = u.user_id
                    LEFT JOIN employer_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN admins admin ON ea.reviewed_by = admin.admin_id
                    ORDER BY ea.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting all accreditations: ' . $e->getMessage());
            return [];
        }
    }

    public function getAccreditationById($accreditationId)
    {
        try {
            $sql = "SELECT 
                        ea.accreditation_id,
                        ea.employer_id,
                        ea.status,
                        ea.created_at,
                        ea.reviewed_at,
                        ea.notes,
                        u.email,
                        e.first_name,
                        e.last_name,
                        e.position,
                        e.contact_no,
                        eb.business_name,
                        eb.company_name,
                        eb.business_type,
                        eb.business_industry,
                        eb.business_team_size,
                        eb.business_desc,
                        eb.business_address,
                        admin.full_name as reviewed_by_name
                    FROM employer_accreditations ea
                    JOIN employers e ON ea.employer_id = e.employer_id
                    JOIN users u ON e.user_id = u.user_id
                    LEFT JOIN employer_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN admins admin ON ea.reviewed_by = admin.admin_id
                    WHERE ea.accreditation_id = :accreditation_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':accreditation_id', $accreditationId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting accreditation by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function updateAccreditationStatus($accreditationId, $status, $reviewerId, $notes = '')
    {
        try {
            $sql = "UPDATE employer_accreditations 
                    SET status = :status, 
                        reviewed_by = :reviewed_by, 
                        reviewed_at = NOW(), 
                        notes = :notes
                    WHERE accreditation_id = :accreditation_id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':reviewed_by', $reviewerId, PDO::PARAM_INT);
            $stmt->bindParam(':notes', $notes);
            $stmt->bindParam(':accreditation_id', $accreditationId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error updating accreditation status: ' . $e->getMessage());
            return false;
        }
    }

    public function createMinimal($userId, $firstName, $lastName, $email = null)
    {
        try {
            return $this->create(
                $userId,
                $firstName,
                $lastName,
                'Employee',     // default position
                null,           // contact_no
                null,           // middle_name
                null,           // company_name
                null            // about_us
            );
        } catch (Exception $e) {
            error_log('Error in createMinimal: ' . $e->getMessage());
            return false;
        }
    }

    public function getTopCompaniesForLanding($limit = 4)
    {
        try {
            $sql = "SELECT DISTINCT
                        e.employer_id,
                        e.user_id,
                        e.status,
                        eb.business_name,
                        eb.business_logo,
                        eb.business_industry,
                        eb.business_type,
                        eb.business_desc,
                        eb.business_address,
                        eb.business_website,
                        eb.facebook_url,
                        eb.twitter_url,
                        eb.instagram_url,
                        eb.youtube_url,
                        COALESCE(job_count.active_jobs, 0) as active_jobs_count
                    FROM employer e
                    INNER JOIN employers_business eb ON e.employer_id = eb.employer_id
                    LEFT JOIN (
                        SELECT employer_id, COUNT(*) as active_jobs
                        FROM job_post 
                        WHERE job_status = 'open' 
                        GROUP BY employer_id
                    ) job_count ON e.employer_id = job_count.employer_id
                    WHERE e.status = 'verified'
                        AND eb.business_name IS NOT NULL
                        AND eb.business_name != ''
                    ORDER BY job_count.active_jobs DESC, e.created_at DESC
                    LIMIT :limit";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process logo paths
            foreach ($results as &$employer) {
                if (!empty($employer['business_logo'])) {
                    // Ensure proper path format
                    if (
                        !str_starts_with($employer['business_logo'], 'http') &&
                        !str_starts_with($employer['business_logo'], 'uploads/')
                    ) {
                        $employer['business_logo'] = 'uploads/' . ltrim($employer['business_logo'], '/');
                    }
                }
            }

            return $results;
        } catch (PDOException $e) {
            error_log('Error getting top companies for landing: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllVerifiedEmployersWithJobCount()
    {
        try {
            $sql = "SELECT e.*, eb.*, 
       COUNT(CASE WHEN jp.job_status = 'open' THEN jp.job_id END) as active_jobs_count
        FROM employer e
        LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
        LEFT JOIN job_post jp ON e.employer_id = jp.employer_id
        WHERE e.status = 'verified'
        GROUP BY e.employer_id
        ORDER BY e.created_at DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting verified employers: ' . $e->getMessage());
            return [];
        }
    }

    public function getDetailedEmployerProfile($employer_id)
    {
        try {
            $sql = "SELECT e.*, eb.* 
                    FROM employer e
                    LEFT JOIN employers_business eb ON e.employer_id = eb.employer_id
                    WHERE e.employer_id = ? AND e.status = 'verified'";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$employer_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting detailed employer profile: ' . $e->getMessage());
            return null;
        }
    }

    public function getEmployerById($employerId)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM employer 
            WHERE employer_id = ?
        ");
            $stmt->execute([$employerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("❌ Error getting employer by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getBusinessInfo($employerId)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM employers_business 
            WHERE employer_id = ?
        ");
            $stmt->execute([$employerId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("❌ Error getting business info: " . $e->getMessage());
            return null;
        }
    }

    public function getCompanyName($employerId)
    {
        try {
            $employer = $this->getEmployerById($employerId);
            if (!$employer) {
                return 'Unknown Company';
            }

            $businessInfo = $this->getBusinessInfo($employerId);
            if ($businessInfo && !empty($businessInfo['business_name'])) {
                return $businessInfo['business_name'];
            }

            return trim($employer['first_name'] . ' ' . $employer['last_name']);
        } catch (Exception $e) {
            error_log("❌ Error getting company name: " . $e->getMessage());
            return 'Unknown Company';
        }
    }

    public function updateEmployerStatus($employer_id, $status)
    {
        try {
            $sql = "UPDATE employer SET status = ?, updated_at = NOW() WHERE employer_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $employer_id]);
        } catch (PDOException $e) {
            error_log("Error updating employer status: " . $e->getMessage());
            return false;
        }
    }
}
