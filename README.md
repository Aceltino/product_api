# Product Management API 🚀

Uma API robusta e escalável para gerenciamento de produtos, desenvolvida com **Laravel 11**, focada em boas práticas de arquitetura, performance com Cache (Redis) e isolamento de responsabilidades.

## 🏗️ Arquitetura e Design Patterns

O projeto segue uma arquitetura em camadas para garantir testabilidade e facilidade de manutenção:

* **Service Layer:** Centraliza as regras de negócio e a orquestração de cache.
* **Repository Pattern:** Desacopla a lógica de persistência do restante da aplicação.
* **DTOs (Data Transfer Objects):** Utiliza objetos tipados e imutáveis (`readonly`) para transporte de dados entre camadas.
* **API Resources:** Garante que a resposta JSON seja padronizada e independente da estrutura do banco de dados.
* **Soft Deletes:** Produtos removidos não são excluídos fisicamente, permitindo auditoria e recuperação.
* **Cache Strategy:** Implementação de `Cache::remember` para listagens e invalidação inteligente no Create/Update/Delete.

## 🛠️ Stack Tecnológica

* **Framework:** Laravel 11 (PHP 8.3)
* **Banco de Dados:** PostgreSQL (Produção/Dev), SQLite (Testes)
* **Cache & Queue:** Redis
* **Containerização:** Docker & Docker Compose
* **Documentação:** Scribe

---

## 🚀 Como Rodar o Projeto

### Pré-requisitos
* Docker e Docker Compose instalados.

### Passo a Passo
1.  **Clone o repositório:**
    ```bash
    git clone https://github.com/Aceltino/product_api.git
    cd product_api
    ```

2.  **Suba os containers:**
    ```bash
    docker compose up -d --build
    ```

3.  **Instale as dependências e configure o ambiente:**
    ```bash
    docker compose exec app composer install
    docker compose exec app cp .env.example .env
    docker compose exec app php artisan key:generate
    ```

4.  **Execute as migrations e seeds:**
    ```bash
    docker compose exec app php artisan migrate --seed
    ```

5.  **Acesse a API:**
    * API: `http://localhost:8000/api/v1/products`
    * Documentação (Scribe): `http://localhost:8000/api/docs`

---

## 📌 Endpoints da API

| Método | Rota | Descrição | Filtros/Params |
| :--- | :--- | :--- | :--- |
| **GET** | `/api/v1/products` | Listagem paginada | `category`, `min_price`, `max_price`, `name` |
| **POST** | `/api/v1/products` | Criar novo produto | Payload JSON |
| **GET** | `/api/v1/products/{id}` | Detalhes do produto | ID do produto |
| **PUT** | `/api/v1/products/{id}` | Atualizar produto | Payload JSON |
| **DELETE** | `/api/v1/products/{id}` | Remoção lógica | ID do produto |
| **PATCH** | `/api/v1/products/{id}/restore` | Restaurar produto | ID do produto |

---

## 🧪 Testes e Qualidade

Os testes utilizam **SQLite in-memory** para máxima velocidade e isolamento.

```bash
# Rodar todos os testes
docker compose exec app php artisan test