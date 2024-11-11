# Sistema de Gerenciamento de Pedidos

## Descrição do Projeto

Este é um sistema de gerenciamento de pedidos e um teste realizado para a empresa Onfly. Tem como objetivo demonstrar meus conhecimentos ao implementar um sistema de agendamento.

## Passos para Execução via Docker

### 1. Atualize as Variáveis de Ambiente

Copie as variáveis de ambiente do arquivo `.env.exemple` para o arquivo `.env`.

### 2. Suba os Containers do Projeto

Execute o seguinte comando para iniciar os containers:

```bash
docker-compose up -d
```

### 3. Acesse o Container

Acesse o container do projeto com o comando:

```bash
docker-compose exec app bash
```

### 4. Instale as Dependências do Projeto

Dentro do container, instale as dependências com o comando:

```bash
composer install
```

### 5. Gere a Key do Projeto Laravel

Dentro do container, gere a chave do Laravel com o comando:

```bash
php artisan key:generate
```

### 6. Execute as Migrations e Seeders

Dentro do container, execute as migrations e seeders com o comando:

```bash
php artisan migrate --seed
```

## Execução dos Testes

Dentro do container, execute os testes com o comando:

```bash
php artisan test
```

## Rotas Existentes

### 1. `api/auth`
- **Descrição:** Rota de autenticação.

### 2. `api/createOrder`
- **Descrição:** Cria um pedido.
- **Validação:**
  - `nome_solicitante`: `required|string`
  - `destino`: `required|string`
  - `data_ida`: `required|date`
  - `data_volta`: `required|date|after_or_equal:data_ida`

### 3. `api/updateOrder/{id}/status`
- **Descrição:** Atualiza o status do pedido.
- **Validação:**
  - `status`: `required|in:aprovado,cancelado`

### 4. `api/consultOrder/{id}`
- **Descrição:** Consulta um pedido pelo ID.

### 5. `api/indexOrders`
- **Descrição:** Lista pedidos por status.