Projeto desenvolvido por mim como desafio técnico utilizando Laravel + Blade + MySQL.
A ideia é criar uma aplicação web para autenticação de usuários e, nas próximas etapas, consumo da PokéAPI, importação de dados, favoritos e controle de permissões por perfil.

# Tecnologias utilizadas

- PHP (Laravel)
- Blade
- MySQL
- Tailwind CSS
- Vite
- Yarn

# Pré-requisitos

Antes de rodar o projeto, é necessário ter instalado:

- PHP 8.2+ (Estou usando o 8.3.1)
- Composer
- Node.js (LTS)
- Yarn
- MySQL

Obs: baixe o carcet.pem, para não ter problema de certificado ssl link: https://curl.se/ca/cacert.pem
aconselho a colocar dentro da pasta do PHP/extra/ssl , isso caso você não tenha ele ou problema de ssl, após isso você vai abrir o seu php.ini e vai procurar por curl.cainfo e vai colocar seu diretorio exemplo: "curl.cainfo="C:\php-8.3.1\extras\ssl\cacert.pem", logo após você vai procurar o openssl.cafile e vai colocar seu diretorio, exemplo: "openssl.cafile="C:\php-8.3.1\extras\ssl\cacert.pem"


# --------- Como rodar o projeto localmente

# 1 - Clonar o repositório

git clone vou passar a url no email
cd pokeapp

Faça um pull só para atualizar o projeto (git pull)

# 2 - Instalar dependências PHP
composer install (Estou usando a versão 2.7.1, caso ocorra algum erro aconselho a instalar essa versão)

# 3 - Copiar arquivo de ambiente e Renomear
.env.example para .env


# 4 - Gerar APP_KEY do laravel pois isso é a segurança do sistema
Execute no terminal php artisan key:generate

# 5 - Edite o .env e configure o banco
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pokeapp
DB_USERNAME=admin ou root
DB_PASSWORD=admin ou root

# 6 - Rodar migrations
Primeiro crie o banco usando o comando CREATE DATABASE pokeapp;
após isso execute o php artisan migrate

# 7 - Rodar seeds
Execute o comando php artisan db:seed para inserir os usuarios e os tipos(types) dos pokemons

# 8 - Instalar dependências frontend
Utilize o comando yarn, pois a extensão Breeze precisa desse gerenciador node.

# 9 - Rodar o Vite e Rodar o Laravel
Em um terminal utilize yarn dev, e em outro terminal utilize php artisan serve, a aplicação vai ficar disponivel em http://127.0.0.1:8000

# 10 - Para logar utilize um dos usuarios inseridos abaixo de cada perfil

    'Perfil Admin'
    email = admin@pokeapp.com
    senha = 123456

    'Perfil Viewer'
    email = viewer@pokeapp.com
    senha = 123456

    'Perfil Editor'
    email = editor@pokeapp.com
    senha = 123456

   