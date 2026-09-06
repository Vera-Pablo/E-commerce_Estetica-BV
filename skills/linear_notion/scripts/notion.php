<?php
require __DIR__ . '/../../../../app/Libraries/LinearNotionSkill.php';
use App\Libraries\LinearNotionSkill;

$payloadJson = $argv[1] ?? '{}';
$payload = json_decode($payloadJson, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Payload no es JSON válido']);
    exit(1);
}

$skill = new LinearNotionSkill();
$result = $skill->run('notion', $payload);
echo json_encode($result);
?>
