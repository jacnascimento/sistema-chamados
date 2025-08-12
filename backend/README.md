# Sistema de Chamados - Backend Laravel 10

Este é o backend do Sistema de Chamados desenvolvido com Laravel 10.

## 🚀 Tecnologias

- **Laravel 10** - Framework PHP
- **MySQL 8.0** - Banco de dados
- **Redis** - Cache e sessões
- **Docker** - Containerização
- **Nginx** - Servidor web

## 📋 Pré-requisitos

- Docker e Docker Compose
- PHP 8.2+ (para desenvolvimento local)
- Composer (para desenvolvimento local)

## 🛠️ Instalação

### Usando Docker (Recomendado)

1. Clone o repositório
2. Navegue para o diretório backend:
   ```bash
   cd backend
   ```

3. Inicie os containers:
   ```bash
   docker-compose up -d
   ```

4. Instale as dependências:
   ```bash
   docker-compose exec app composer install
   ```

5. Gere a chave da aplicação:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. Execute as migrações:
   ```bash
   docker-compose exec app php artisan migrate
   ```

### Desenvolvimento Local

1. Instale as dependências:
   ```bash
   composer install
   ```

2. Copie o arquivo de ambiente:
   ```bash
   cp env.example .env
   ```

3. Configure o banco de dados no arquivo `.env`

4. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

5. Execute as migrações:
   ```bash
   php artisan migrate
   ```

## 🌐 Acessos

- **Aplicação**: http://localhost:8000
- **Banco de dados**: localhost:3306
- **Redis**: localhost:6379

## 📚 Estrutura da API

### Endpoints Disponíveis

- `GET /` - Página inicial
- `GET /api/health` - Status da API
- `GET /api/tickets` - Listar tickets
- `POST /api/tickets` - Criar ticket
- `GET /api/tickets/{id}` - Visualizar ticket
- `PUT /api/tickets/{id}` - Atualizar ticket
- `DELETE /api/tickets/{id}` - Remover ticket

## 🔧 Comandos Úteis

```bash
# Executar testes
php artisan test

# Limpar cache
php artisan cache:clear

# Limpar configurações
php artisan config:clear

# Listar rotas
php artisan route:list

# Criar controller
php artisan make:controller NomeController

# Criar modelo
php artisan make:model NomeModel

# Criar migração
php artisan make:migration create_nome_table
```

## 📁 Estrutura de Diretórios

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
├── resources/
│   └── views/
├── routes/
├── storage/
└── tests/
```

## 🐳 Docker

O projeto inclui configuração Docker completa:

- **app**: Container PHP 8.2 com FPM
- **db**: MySQL 8.0
- **redis**: Redis 7
- **nginx**: Nginx Alpine

## 📝 Licença

Este projeto está sob a licença MIT.
