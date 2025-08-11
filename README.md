# gerar_hash_resumo_digital

<p align="center">
Gerar um Hash para Resumo Digital da Aplicação
</p>

<hr />

<p align="left">
Com esse script PHP você consegue gerar uma hash como o exemplo abaixo para sua apicação.

No formato txt
=====================================================================

📄 RESUMO DIGITAL DE HOMOLOGAÇÃO

🕒 Data de geração: 2025-08-11 09:36:43

📁 Frontend: /var/www/html/meu-projeto-frontend/

🔐 Hash Frontend: 159c5f018c5ccfd38259d08492e92ea752e7eb90f01657d7dc55614448f1eca45b637b3bc11f731f3ba08097dbb3a1780b09d76986d6eb0283d49fd92a24eb0e

📁 Backend: /var/www/html/meu-projeto-backend

🔐 Hash Backend: 5168ef4facdea6b0d2237d775f82094731d6439db8e0c5b5487f871b6fcbb859731abdb9e9d0534855b72cc7c181a9ee45102d2e9b83b075d06880305cb5157f

📁 API: /var/www/html/advintegra/meu-projeto-api

🔐 Hash API: 990972d872c9b7b46f9c7f9699ac68650ccfb18eb26c1ac347de70ccd96703775d2aeed59e589cbebdd2c20533a96f5ffb8539e3911ab50ccfc23bafe5177c7b

🔒 Hash Consolidado do Sistema: e4b6240892642336e6618d54157de2d063d986665302006d36a086aef2701a9ab5f7853fd9ed9fbb927283798db33dcf74f4dd137e98d84f83343d8a34ce335a

=====================================================================

No formato JSON
<code>
{
    "data_geracao": "2025-08-11 09:48:09",
    "frontend": {
        "caminho": "/var/www/html/meu-projeto-frontend/",
        "hash": "159c5f018c5ccfd38259d08492e92ea752e7eb90f01657d7dc55614448f1eca45b637b3bc11f731f3ba08097dbb3a1780b09d76986d6eb0283d49fd92a24eb0e"
    },
    "backend": {
        "caminho": "/var/www/html/meu-projeto-backend",
        "hash": "5168ef4facdea6b0d2237d775f82094731d6439db8e0c5b5487f871b6fcbb859731abdb9e9d0534855b72cc7c181a9ee45102d2e9b83b075d06880305cb5157f"
    },
    "api": {
        "caminho": "/var/www/html/meu-projeto-api/",
        "hash": "990972d872c9b7b46f9c7f9699ac68650ccfb18eb26c1ac347de70ccd96703775d2aeed59e589cbebdd2c20533a96f5ffb8539e3911ab50ccfc23bafe5177c7b"
    },
    "hash_final_sistema": "e4b6240892642336e6618d54157de2d063d986665302006d36a086aef2701a9ab5f7853fd9ed9fbb927283798db33dcf74f4dd137e98d84f83343d8a34ce335a"
}
</code>

# Exemplo de uso
php gerar_hash_resumo_digital.php /var/www/html/meu-projeto-frontend/ /var/www/html/meu-projeto-backend/ /var/www/html/ameu-projeto-api/

Você também pode usar com um unico diretório, o script esta preparado para aceitar no máximo 3 diretórios, se precisar de mais você pode ajustar o código seguindo a lógica aplicada para leitura de cada diretório.

</p>
