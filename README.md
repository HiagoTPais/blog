# CyberSec Blog

Blog pessoal de cybersegurança e portfólio técnico do **Hiago Pais**, construído com Laravel, Inertia.js, Vue 3 e Tailwind CSS.

## Stack

- Laravel 12 / PHP 8.4+
- Inertia.js + Vue 3 (Composition API)
- Tailwind CSS 4
- MySQL
- Vite
- Pinia, Shiki, Marked, DOMPurify

## Setup

```bash
# Instalar dependências
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar MySQL no .env e criar o banco
# DB_DATABASE=blog

# Migrar e popular dados de exemplo
php artisan migrate
php artisan db:seed
php artisan storage:link

# Build frontend
npm run build

# Desenvolvimento
composer dev
```

## Credenciais Admin (seed)

- **Email:** admin@blog.local
- **Senha:** password

## Rotas Principais

| Rota | Descrição |
|------|-----------|
| `/` | Home — lista de artigos |
| `/posts/{slug}` | Artigo completo |
| `/categories` | Categorias |
| `/about` | Sobre Hiago Pais |
| `/contact` | Formulário de contato |
| `/admin/dashboard` | Painel administrativo |
| `/admin/posts` | CRUD de posts |
| `/sitemap.xml` | Sitemap SEO |

## Estrutura

```
app/
├── Http/Controllers/     # Controllers públicos e admin
├── Http/Requests/        # Form Requests com validação
├── Http/Resources/       # API Resources
├── Policies/             # Autorização
├── Services/             # Lógica de negócio
└── Models/               # Eloquent models

resources/js/
├── Components/Blog/      # Componentes reutilizáveis
├── Composables/          # useSearch, useMarkdown
├── Layouts/              # BlogLayout, AdminLayout
├── Pages/                # Páginas Inertia
├── Stores/               # Pinia store
└── Helpers/              # Utilitários
```

## Segurança

- CSRF em todos os formulários
- Rate limiting no contato (5 req/min)
- Markdown sanitizado (HTML strip + DOMPurify no frontend)
- Policies para autorização admin
- SQL Injection protegido via Eloquent

## Licença

MIT
