# Projeto Laravel + PostgreSQL + Docker

## Requisitos

- Docker
- Docker Compose

## Subir ambiente

Na raiz do projeto execute:

```bash
docker compose up -d --build
```

Verificar containers:

```bash
docker ps
```

## Instalar Laravel

Caso o projeto ainda não exista:

```bash
docker exec -it cobuccio-app bash

composer create-project laravel/laravel .
```

## Gerar chave da aplicação

```bash
docker exec -it cobuccio-app php artisan key:generate
```

## Executar migrations

```bash
docker exec -it cobuccio-app php artisan migrate
```

## Acessar aplicação

http://localhost:8000

## Acessar PostgreSQL

Host:

```text
postgres
```

Porta:

```text
5432
```

Banco:

```text
cobucciodb
```

Usuário:

```text
postgres
```

Senha:

```text
123456
```

## Acessar Adminer

http://localhost:8080

Preencher:

Sistema:

```text
PostgreSQL
```

Servidor:

```text
postgres
```

Usuário:

```text
postgres
```

Senha:

```text
123456
```

Banco:

```text
cobucciodb
```

## Derrubar ambiente

```bash
docker compose down
```

## Derrubar ambiente removendo dados

```bash
docker compose down -v
```