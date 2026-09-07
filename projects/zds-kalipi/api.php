<?php
/**
 * ZAMBOANGA DEL SUR KALIPI-RIC WOMEN FEDERATION, INC.
 * Backend REST API (MySQL PDO) + Remote Data Sync
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($requestMethod === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/config.php';

$host = DB_HOST;
$db   = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;
$charset = DB_CHARSET;

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]);
    exit();
}

$action = $_GET['action'] ?? 'get_all';
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

try {
    switch ($action) {
        case 'get_all':
            $stmtAssoc = $pdo->query("SELECT * FROM barangay_associations ORDER BY id ASC LIMIT 1");
            $assoc = $stmtAssoc->fetch();

            if (!$assoc) {
                $assoc = [
                    'id' => 1,
                    'municipality' => 'Pagadian City',
                    'barangay' => 'San Jose',
                    'association_name' => "KALIPI San Jose Women's Association, Inc.",
                    'president_leader' => 'Ma. Elena S. Santos',
                    'contact_number' => '0917-890-1234',
                    'dole_registration_no' => 'DOLE-IX-2024-0589-WA'
                ];
            }

            $associationData = [
                'id' => $assoc['id'],
                'municipality' => $assoc['municipality'],
                'barangay' => $assoc['barangay'],
                'associationName' => $assoc['association_name'],
                'presidentLeader' => $assoc['president_leader'],
                'contactNo' => $assoc['contact_number'],
                'doleRegNo' => $assoc['dole_registration_no']
            ];

            $stmtProf = $pdo->query("SELECT * FROM women_profiles ORDER BY id ASC");
            $rawProfiles = $stmtProf->fetchAll();

            $profiles = array_map(function($p) {
                $computedAge = (int)$p['age'];
                if (!empty($p['birthdate'])) {
                    $bDate = new DateTime($p['birthdate']);
                    $today = new DateTime();
                    $computedAge = $today->diff($bDate)->y;
                }

                $img = !empty($p['img_url']) ? $p['img_url'] : $p['avatar_url'];

                return [
                    'id' => (string)$p['id'],
                    'dbId' => (int)$p['id'],
                    'name' => $p['full_name'],
                    'birthdate' => $p['birthdate'],
                    'age' => $computedAge,
                    'civilStatus' => $p['civil_status'],
                    'occupation' => $p['occupation'],
                    'position' => $p['position'],
                    'contactNo' => $p['contact_number'],
                    'remarks' => $p['remarks'],
                    'avatar' => $img,
                    'imgUrl' => $img,
                    'avatar_url' => $img,
                    'img_url' => $img
                ];
            }, $rawProfiles);

            echo json_encode([
                'status' => 'success',
                'association' => $associationData,
                'profiles' => $profiles
            ]);
            break;

        case 'save_profile':
            $name = trim($input['name'] ?? '');
            $birthdate = trim($input['birthdate'] ?? '');
            $age = intval($input['age'] ?? 0);

            if ($birthdate) {
                try {
                    $bDate = new DateTime($birthdate);
                    $today = new DateTime();
                    $calcAge = $today->diff($bDate)->y;
                    if ($calcAge >= 0) {
                        $age = $calcAge;
                    }
                } catch (\Exception $e) {}
            }

            $civilStatus = $input['civilStatus'] ?? 'Married';
            $occupation = trim($input['occupation'] ?? '');
            $position = $input['position'] ?? 'Member';
            $contactNo = trim($input['contactNo'] ?? '');
            $remarks = trim($input['remarks'] ?? '');
            
            // Support avatar, imgUrl, avatar_url, img_url input field names
            $avatar = trim($input['imgUrl'] ?? $input['img_url'] ?? $input['avatar'] ?? $input['avatar_url'] ?? '');
            
            $id = $input['id'] ?? null;
            $dbId = isset($input['dbId']) ? intval($input['dbId']) : (is_numeric($id) ? intval($id) : null);

            if (!$name) {
                echo json_encode(['status' => 'error', 'message' => 'Full Name is required.']);
                exit();
            }

            if ($dbId) {
                $stmt = $pdo->prepare("UPDATE women_profiles SET 
                    full_name = :name,
                    birthdate = :birthdate,
                    age = :age,
                    civil_status = :civilStatus,
                    occupation = :occupation,
                    position = :position,
                    contact_number = :contactNo,
                    remarks = :remarks,
                    avatar_url = :avatar,
                    img_url = :imgUrl
                    WHERE id = :id");
                $stmt->execute([
                    ':name' => $name,
                    ':birthdate' => $birthdate ?: null,
                    ':age' => $age,
                    ':civilStatus' => $civilStatus,
                    ':occupation' => $occupation,
                    ':position' => $position,
                    ':contactNo' => $contactNo,
                    ':remarks' => $remarks,
                    ':avatar' => $avatar,
                    ':imgUrl' => $avatar,
                    ':id' => $dbId
                ]);
                $savedId = $dbId;
            } else {
                $stmt = $pdo->prepare("INSERT INTO women_profiles 
                    (association_id, full_name, birthdate, age, civil_status, occupation, position, contact_number, remarks, avatar_url, img_url)
                    VALUES (1, :name, :birthdate, :age, :civilStatus, :occupation, :position, :contactNo, :remarks, :avatar, :imgUrl)");
                $stmt->execute([
                    ':name' => $name,
                    ':birthdate' => $birthdate ?: null,
                    ':age' => $age,
                    ':civilStatus' => $civilStatus,
                    ':occupation' => $occupation,
                    ':position' => $position,
                    ':contactNo' => $contactNo,
                    ':remarks' => $remarks,
                    ':avatar' => $avatar,
                    ':imgUrl' => $avatar
                ]);
                $savedId = $pdo->lastInsertId();
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Profile saved successfully.',
                'id' => (string)$savedId,
                'computedAge' => $age,
                'imgUrl' => $avatar
            ]);
            break;

        case 'delete_profile':
            $id = $input['id'] ?? null;
            $dbId = isset($input['dbId']) ? intval($input['dbId']) : (is_numeric($id) ? intval($id) : null);

            if ($dbId) {
                $stmt = $pdo->prepare("DELETE FROM women_profiles WHERE id = :id");
                $stmt->execute([':id' => $dbId]);
                echo json_encode(['status' => 'success', 'message' => 'Profile deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Profile ID.']);
            }
            break;

        case 'save_association':
            $municipality = trim($input['municipality'] ?? 'Pagadian City');
            $barangay = trim($input['barangay'] ?? 'San Jose');
            $associationName = trim($input['associationName'] ?? '');
            $presidentLeader = trim($input['presidentLeader'] ?? '');
            $contactNo = trim($input['contactNo'] ?? '');
            $doleRegNo = trim($input['doleRegNo'] ?? '');

            $stmt = $pdo->prepare("UPDATE barangay_associations SET 
                municipality = :municipality,
                barangay = :barangay,
                association_name = :assocName,
                president_leader = :president,
                contact_number = :contact,
                dole_registration_no = :doleReg
                WHERE id = 1");

            $stmt->execute([
                ':municipality' => $municipality,
                ':barangay' => $barangay,
                ':assocName' => $associationName,
                ':president' => $presidentLeader,
                ':contact' => $contactNo,
                ':doleReg' => $doleRegNo
            ]);

            echo json_encode(['status' => 'success', 'message' => 'Association info updated successfully.']);
            break;

        // --- REMOTE SYNC HANDLERS ---
        case 'sync_push':
            $key = $input['syncKey'] ?? '';
            if ($key !== SYNC_SECRET_KEY) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid Sync Secret Key.']);
                exit();
            }

            if (isset($input['associationInfo'])) {
                $a = $input['associationInfo'];
                $stmt = $pdo->prepare("UPDATE barangay_associations SET 
                    municipality = :m, barangay = :b, association_name = :an, president_leader = :p, contact_number = :c, dole_registration_no = :d 
                    WHERE id = 1");
                $stmt->execute([
                    ':m' => $a['municipality'] ?? 'Pagadian City',
                    ':b' => $a['barangay'] ?? 'San Jose',
                    ':an' => $a['associationName'] ?? '',
                    ':p' => $a['presidentLeader'] ?? '',
                    ':c' => $a['contactNo'] ?? '',
                    ':d' => $a['doleRegNo'] ?? ''
                ]);
            }

            if (isset($input['profiles']) && is_array($input['profiles'])) {
                $pdo->exec("DELETE FROM women_profiles");
                $stmtIns = $pdo->prepare("INSERT INTO women_profiles 
                    (association_id, full_name, birthdate, age, civil_status, occupation, position, contact_number, remarks, avatar_url, img_url) 
                    VALUES (1, :name, :birthdate, :age, :civilStatus, :occupation, :position, :contactNo, :remarks, :avatar, :imgUrl)");

                foreach ($input['profiles'] as $p) {
                    $bdate = $p['birthdate'] ?? null;
                    $calcAge = intval($p['age'] ?? 0);
                    if ($bdate && $calcAge <= 0) {
                        try {
                            $calcAge = (new DateTime())->diff(new DateTime($bdate))->y;
                        } catch (\Exception $e) {}
                    }

                    $img = $p['imgUrl'] ?? $p['img_url'] ?? $p['avatar'] ?? $p['avatar_url'] ?? '';

                    $stmtIns->execute([
                        ':name' => $p['name'],
                        ':birthdate' => $bdate ?: null,
                        ':age' => $calcAge,
                        ':civilStatus' => $p['civilStatus'] ?? 'Married',
                        ':occupation' => $p['occupation'] ?? '',
                        ':position' => $p['position'] ?? 'Member',
                        ':contactNo' => $p['contactNo'] ?? '',
                        ':remarks' => $p['remarks'] ?? '',
                        ':avatar' => $img,
                        ':imgUrl' => $img
                    ]);
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Database synchronized successfully!']);
            break;

        case 'trigger_sync_remote':
            $targetUrl = $input['remoteUrl'] ?? REMOTE_SERVER_URL;
            $syncKey = $input['syncKey'] ?? SYNC_SECRET_KEY;

            $stmtAssoc = $pdo->query("SELECT * FROM barangay_associations ORDER BY id ASC LIMIT 1");
            $assoc = $stmtAssoc->fetch();
            $stmtProf = $pdo->query("SELECT * FROM women_profiles ORDER BY id ASC");
            $rawProfiles = $stmtProf->fetchAll();

            $payload = [
                'syncKey' => $syncKey,
                'associationInfo' => [
                    'municipality' => $assoc['municipality'],
                    'barangay' => $assoc['barangay'],
                    'associationName' => $assoc['association_name'],
                    'presidentLeader' => $assoc['president_leader'],
                    'contactNo' => $assoc['contact_number'],
                    'doleRegNo' => $assoc['dole_registration_no']
                ],
                'profiles' => array_map(function($p) {
                    $img = !empty($p['img_url']) ? $p['img_url'] : $p['avatar_url'];
                    return [
                        'name' => $p['full_name'],
                        'birthdate' => $p['birthdate'],
                        'age' => (int)$p['age'],
                        'civilStatus' => $p['civil_status'],
                        'occupation' => $p['occupation'],
                        'position' => $p['position'],
                        'contactNo' => $p['contact_number'],
                        'remarks' => $p['remarks'],
                        'avatar' => $img,
                        'imgUrl' => $img
                    ];
                }, $rawProfiles)
            ];

            $ch = curl_init($targetUrl . '?action=sync_push');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);

            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err) {
                echo json_encode(['status' => 'error', 'message' => 'cURL Error: ' . $err]);
            } else {
                echo $result;
            }
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown API action.']);
            break;
    }
} catch (\Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
