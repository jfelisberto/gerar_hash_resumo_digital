#!/usr/bin/env php
<?php
/**
 * Usage
 *
 * php gerar_hash_summary_digital.php /caminho_da_aplicacao_front-end /caminho_da_aplicacao_back-end /caminho_da_aplicacao_api
 */

/**
 * Define a localidade e timezone para SP/Brasil
 */
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

/**
 * Define o hash a ser utilizado
 */
define('HASH', 'sha512');

/**
 * Gera o hash do diretório especificado
 */
function gerarHashDoDiretorio($path, $exts = ['php', 'tsx', 'ts', 'js', 'html', 'css', 'vue', 'json']) {

    $content = '';
    $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS));

    foreach ($iterador as $file) {

        if ($file->isFile() &&in_array(strtolower($file->getExtension()), $exts)) {

            $content .= file_get_contents($file->getRealPath());

        }
    }

    return hash(HASH, $content);

}

$frontend_path = $argv[1] ?? false;
$backend_path  = $argv[2] ?? false;
$api_path      = $argv[3] ?? false;

$hash_front = gerarHashDoDiretorio($frontend_path);

$hash_merged = $frontend_path;
$app_first_key = 'Aplicacao';

if (!empty($backend_path)) {

    $hash_back  = gerarHashDoDiretorio($backend_path);
    $hash_merged .= $hash_back;
    $app_first_key = 'Frontend';

}

if (!empty($api_path)) {

    $hash_api    = gerarHashDoDiretorio($api_path);
    $hash_merged .= $hash_api;
    $app_first_key = 'Frontend';

}

if (!empty($backend_path) || !empty($api_path)) {

    $hash_final   = hash(HASH, $hash_merged);

}

$generate_date = date('Y-m-d H:i:s', time());
$file_prefix  = date('YmdHis', time());

/**
 * Criar array de Resumo
 */
$summary = [
    'data_geracao' => $generate_date,
    strtolower($app_first_key) => [
        'caminho' => $frontend_path,
        'hash' => $hash_front,
    ]
];


if (!empty($backend_path)) {
    $summary['backend'] = [
        'caminho' => $backend_path,
        'hash' => $hash_back,
    ];
}

if (!empty($api_path)) {

    $summary['api'] = [
        'caminho' => $api_path,
        'hash' => $hash_api,
    ];

}


if (!empty($backend_path) || !empty($api_path)) {

    $summary['hash_consolidada_do_sistema'] = $hash_final;

}

/**
 * Salva como JSON
 */
file_put_contents($file_prefix . '_summary_digital.json', json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

/**
 * Salva como TXT (humano legível)
 */
$txt = "=====================================================================\n
📄 RESUMO DIGITAL DE HOMOLOGAÇÃO\n
🕒 Data de geração: {$generate_date}\n
📁 {$app_first_key}: {$frontend_path}\n
🔐 Hash {$app_first_key}: {$hash_front}\n";

if (!empty($backend_path)) {

    $txt .= "\n📁 Backend: {$backend_path}\n\n🔐 Hash Backend: {$hash_back}\n";

}

if (!empty($api_path)) {

    $txt .= "\n📁 API: {$api_path}\n\n🔐 Hash API: {$hash_api}\n";

}

if (!empty($backend_path) || !empty($api_path)) {

    $txt .= "\n🔒 Hash Consolidada do Sistema: {$hash_final}\n";

}
$txt .= "\n=====================================================================\n";

file_put_contents($file_prefix . '_summary_digital.txt', $txt);

/**
 * Exibir o summary digital no terminal
 */
print $txt . PHP_EOL;
