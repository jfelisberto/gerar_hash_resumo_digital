#!/usr/bin/env php
<?php
/**
 * Usage
 *
 * php gerar_hash_resumo_digital.php /caminho_da_aplicacao_front-end /caminho_da_aplicacao_back-end /caminho_da_aplicacao_api
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

    $conteudoTotal = '';
    $iterador = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS));

    foreach ($iterador as $arquivo) {

        if ($arquivo->isFile() &&in_array(strtolower($arquivo->getExtension()), $exts)) {

            $conteudoTotal .= file_get_contents($arquivo->getRealPath());

        }
    }

    return hash(HASH, $conteudoTotal);

}

$frontendPath = $argv[1] ?? false;
$backendPath  = $argv[2] ?? false;
$apiPath      = $argv[3] ?? false;

$hashFront = gerarHashDoDiretorio($frontendPath);

$hashMerged = $frontendPath;
$app_first_key = 'Aplicacao';

if (!empty($backendPath)) {

    $hashBack  = gerarHashDoDiretorio($backendPath);
    $hashMerged .= $hashBack;
    $app_first_key = 'Frontend';

}

if (!empty($apiPath)) {

    $hashApi    = gerarHashDoDiretorio($apiPath);
    $hashMerged .= $hashApi;
    $app_first_key = 'Frontend';

}

if (!empty($backendPath) || !empty($apiPath)) {

    $hashFinal   = hash(HASH, $hashMerged);

}

$dataGeracao = date('Y-m-d H:i:s', time());
$fileprefix  = date('YmdHis', time());

/**
 * Criar array de resumo
 */
$resumo = [
    'data_geracao' => $dataGeracao,
    strtolower($app_first_key) => [
        'caminho' => $frontendPath,
        'hash' => $hashFront,
    ]
];


if (!empty($backendPath)) {
    $resumo['backend'] = [
        'caminho' => $backendPath,
        'hash' => $hashBack,
    ];
}

if (!empty($apiPath)) {

    $resumo['api'] = [
        'caminho' => $apiPath,
        'hash' => $hashApi,
    ];

}


if (!empty($backendPath) || !empty($apiPath)) {

    $resumo['hash_consolidada_do_sistema'] = $hashFinal;

}

/**
 * Salva como JSON
 */
file_put_contents($fileprefix . '_resumo_digital.json', json_encode($resumo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

/**
 * Salva como TXT (humano legível)
 */
$txt = "=====================================================================\n
📄 RESUMO DIGITAL DE HOMOLOGAÇÃO\n
🕒 Data de geração: {$dataGeracao}\n
📁 {$app_first_key}: {$frontendPath}\n
🔐 Hash {$app_first_key}: {$hashFront}\n";

if (!empty($backendPath)) {

    $txt .= "\n📁 Backend: {$backendPath}\n\n🔐 Hash Backend: {$hashBack}\n";

}

if (!empty($apiPath)) {

    $txt .= "\n📁 API: {$apiPath}\n\n🔐 Hash API: {$hashApi}\n";

}

if (!empty($backendPath) || !empty($apiPath)) {

    $txt .= "\n🔒 Hash Consolidada do Sistema: {$hashFinal}\n";

}
$txt .= "\n=====================================================================\n";

file_put_contents($fileprefix . '_resumo_digital.txt', $txt);

/**
 * Exibir o resumo digital no terminal
 */
print $txt . PHP_EOL;
