// FOR FIREBASE NOTIFICATION

<?php
// public/api/save_token.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/sikap_db.php';

if (!isset($_SESSION['user_id'])) { http_response_code(401); echo json_encode(['error'=>'Not authenticated']); exit; }

$input = json_decode(file_get_contents('php://input'), true);
$token = $input['token'] ?? '';
if (!$token) { http_response_code(400); echo json_encode(['error'=>'Missing token']); exit; }

$user_id = intval($_SESSION['user_id']);
$stmt = $conn->prepare("UPDATE users SET fcm_token = ? WHERE id = ?");
$stmt->bind_param("si", $token, $user_id);
if ($stmt->execute()) echo json_encode(['ok'=>true]); else { http_response_code(500); echo json_encode(['error'=>'DB']); }
