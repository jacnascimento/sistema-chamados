# Sistema de Chamados - Laravel 10 + Vue 3

Sistema completo de gerenciamento de chamados com backend em Laravel 10 e frontend em Vue 3.

## Estrutura do Projeto

```
sistema-chamados/
├── backend/          # Laravel 10 API
├── frontend/         # Vue 3 SPA
└── docker/           # Configurações Docker
```

## Pré-requisitos

- Docker e Docker Compose
- Node.js 18+ (para desenvolvimento frontend)
- PHP 8.1+ (para desenvolvimento backend)

## Instalação e Execução

### Backend (Laravel)

```bash
cd backend
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan serve --host=0.0.0.0 --port=8000
```

### Frontend (Vue 3)

```bash
cd frontend
npm install
npm run dev
```

## Acesso

- **Backend API**: http://localhost:8000
- **Frontend**: http://localhost:5173
- **Banco de Dados**: MySQL (porta 3306)

## Tecnologias

### Backend
- Laravel 10
- MySQL 8.0
- Redis (cache)
- Docker

### Frontend
- Vue 3
- Vite
- Tailwind CSS
- Axios
- Vue Router
- Pinia (state management)
