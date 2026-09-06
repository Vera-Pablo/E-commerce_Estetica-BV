<?php
namespace App\Libraries;

class LinearNotionSkill
{
    /**
     * Ejecuta la acción solicitada.
     * @param string $accion   "linear" o "notion"
     * @param array  $payload  Datos del ticket o página
     * @return array           Resultado estructurado
     */
    public function run(string $accion, array $payload): array
    {
        if ($accion === 'linear') {
            $json = escapeshellarg(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $cmd = "opencode mcp call linear $json";
        } elseif ($accion === 'notion') {
            $json = escapeshellarg(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $cmd = "opencode mcp call notion $json";
        } else {
            return ['success' => false, 'error' => 'Acción no soportada'];
        }

        $output = [];
        $returnVar = 0;
        exec($cmd, $output, $returnVar);

        if ($returnVar !== 0) {
            return ['success' => false, 'error' => implode("\n", $output)];
        }

        $response = implode("", $output);
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error' => 'Respuesta no es JSON válida'];
        }
        return ['success' => true, 'data' => $data];
    }
}
?>
