# API de Gerenciamento de Produtos - Desafio Backend Laravel

Esta é uma API RESTful desenvolvida para o gerenciamento de produtos, focada em escalabilidade e manutenção.

## 🚀 Tecnologias
- **Framework:** Laravel 11 (PHP 8.3)
- **Banco de Dados:** PostgreSQL
- **Containerização:** Docker & Docker Compose
- **Arquitetura:** Service Layer & Repository Pattern

## 📦 Como Rodar o Projeto

1. **Clone o projeto:**
   ```bash
   git clone [https://github.com/Aceltino/product_api.git](https://github.com/Aceltino/product_api.git)
   ```
2. **Suba os containers:**
   ```bash
   docker compose up -d --build
   ```
3. **Setup inicial:**
   ```bash
   docker compose exec app composer install
   docker compose exec app php artisan key:generate
   docker compose exec app php artisan migrate --seed
   ```
```