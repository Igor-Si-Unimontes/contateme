# Contateme

Contateme foi um projeto feito em vue3 e Laravel 10 e conectados com o Inertia, o banco de dados feito com Mysql e servido no apache do XAMPP.
O objetivo do projeto é o usuario ter um controle de seus contatos telefonicos.

## Apresentação da Aplicação

Assista ao vídeo de apresentação aqui: [Vídeo de Apresentação](https://www.youtube.com/watch?v=pZ82Zlz8fNo)

## Funcionalidades d Contateme

- Login , mudança de senha , criaçao de novo usuario
- Cadastro de contatos
- Edição de contatos
- Exclusão de contatos
- Listagem de contatos
- Visualização de detalhes de contatos
- Apagar perfil

## Tecnologias Utilizadas

- Laravel 10
- MySQL 8.0
- Vue.js
- Bootstrap

## Instalação

### Para executar a aplicação localmente (Sem Docker), siga os passos abaixo:

1. Clone o repositório:
    ```sh
    git clone https://github.com/Igor-Si-Unimontes/contateme
    ```
2. Acesse a pasta do projeto:
    ```sh
    cd contateme
    ```
3. Instale as dependências do Composer:
    ```sh
    composer install
    ```
4. Copie o arquivo `.env.example` para `.env`:
    ```sh
    cp .env.example .env
    ```
5. Gere a chave da aplicação:
    ```sh
    php artisan key:generate
    ```
6. Configure o arquivo `.env` com as informações do banco de dados:
7. Execute as migrações do banco de dados:
    ```sh
    php artisan migrate
    ```
8. Inicie os servidores do back-end e do front-end:
    ```sh
    php artisan serve
    npm run dev
    ```
9. Acesse a aplicação em seu navegador através do endereço [http://localhost:8000](http://localhost:8000)

Meus contatos são:

Email: igorunimoc@gmail.com
Telefone : (38)98837-1640
