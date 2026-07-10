# CyberSec Blog

Blog pessoal. Construído com Laravel e Vue.js.

## Sobre o projeto

Aplicação web com área pública para leitura de artigos e painel administrativo para gerenciar posts. Os artigos são escritos em Markdown, com suporte a categorias, tags, busca, SEO e formulário de contato.

## Tecnologias

- **Backend:** Laravel 13, PHP 8.3
- **Frontend:** Vue 3, Inertia.js, Tailwind CSS
- **Build:** Vite
- **Banco de dados:** Mysql

## Requisitos

- PHP 8.3+
- Composer
- Node.js 18+
- npm

## Instalação

```bash
composer setup
```

Esse comando instala as dependências, cria o `.env`, gera a chave da aplicação, executa as migrations e compila os assets.

Para popular o banco com dados de exemplo:

```bash
php artisan db:seed
```

## Desenvolvimento

```bash
composer dev
```


