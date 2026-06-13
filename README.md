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
```bash
docker exec -it cobuccio-app composer install
```

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
cobucciodb2
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
cobucciodb2
```

## Derrubar ambiente

```bash
docker compose down
```

## Derrubar ambiente removendo dados

```bash
docker compose down -v
```