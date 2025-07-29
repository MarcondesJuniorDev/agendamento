# Agendamento

Aplicação para agendamento de serviços desenvolvida em Laravel PHP, utilizando a stack Filament PHP e executada via Docker (PHP + Nginx + MySQL).

## Tecnologias

- [Laravel](https://laravel.com/)
- [Filament PHP](https://filamentphp.com/)
- [Docker](https://www.docker.com/)
- PHP, Nginx, MySQL

## Como rodar o projeto

1. Clone o repositório:
    ```bash
    git clone https://github.com/MarcondesJuniorDev/agendamento
    cd agendamento
    ```

2. Copie o arquivo de exemplo de ambiente:
    ```bash
    cp .env.example .env
    ```

3. Suba os containers Docker:
    ```bash
    docker-compose up -d
    ```

4. Instale as dependências do Laravel:
    ```bash
    docker-compose exec app composer install
    ```

5. Gere a chave da aplicação:
    ```bash
    docker-compose exec app php artisan key:generate
    ```

6. Acesse a aplicação em [http://localhost:8080](http://localhost:8080)

## Licença

Este projeto está sob a licença MIT.