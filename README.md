<h1 align="center">
  <img align="right" height="45" width="45" src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-plain.svg" alt="PHP" />
  🍕 Sistema Web Restaurante
  <img align="left" height="45" width="45" src="https://raw.githubusercontent.com/devicons/devicon/master/icons/bootstrap/bootstrap-plain.svg" alt="Bootstrap" />
</h1>

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-4.0-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-1.25-009639?style=for-the-badge&logo=nginx&logoColor=white)

</div>

<br>

## 📝 Descrição

O **Sistema Web Restaurante** é uma aplicação web fullstack desenvolvida em **PHP com PDO, MySQL e Bootstrap 4** para gerenciamento de cardápio (produtos) e registro de itens de pedidos em restaurantes e pizzarias. O projeto conta com autenticação de usuários, controle de sessão seguro, operações de CRUD com exclusão lógica (*soft delete* via status `HABILITADO`/`DESABILITADO`), remoção assíncrona via AJAX (`XMLHttpRequest`) e infraestrutura híbrida pronta para rodar tanto localmente (Laragon/XAMPP) quanto em containers **Docker** otimizados.

<cite>Sistema web prático e direto para controle de produtos de cardápio e lançamento de itens de pedidos em restaurantes.</cite>

---

## 🚦 Status do Projeto

<h4 align="center"> ✅ Sistema Web Restaurante 🚀 Concluído & Dockerizado ⚙️ </h4>

---

## 🏗️ Arquitetura do Projeto

- **Tipo:** 🧱 **Monólito Fullstack (MVC Simplificado)**
- **Explicação:** O projeto integra o front-end (views renderizadas em PHP com estilização Bootstrap 4 e interações em JavaScript/AJAX) e o back-end (camada de conexão PDO `BancoDados`, Models `Produto` e `Usuario`, e Controllers `ProdutoController` e `UsuarioController`) na mesma base de código, conectando-se ao banco de dados relacional MySQL (`restaurante-bd`).

---

## 🔥 Pré-requisitos

Para executar o projeto, você precisará de uma das opções abaixo:

### Opção 1 — Com Docker (Recomendado)
- **Docker Desktop** `24.0+` e **Docker Compose** `v2+`

### Opção 2 — Ambiente Local (Laragon / XAMPP / Nativo)
- **PHP** `8.2+` (compatível com `7.4+`) com extensões `pdo`, `pdo_mysql`, `mbstring`, `intl`
- **MySQL** `8.0+` (ou `5.7+` / MariaDB `10.4+`)

---

## 🚀 Tecnologias Utilizadas

- **Linguagem:** PHP `8.2+`
- **Banco de Dados:** MySQL `8.0` (`PDO` com *Prepared Statements*)
- **Front-end:** HTML5, CSS3, Bootstrap `4.0.0`, JavaScript (ES6 / `XMLHttpRequest` AJAX), jQuery `3.2.1`
- **Infraestrutura & DevOps:** Docker, Docker Compose, Nginx `1.25-alpine`, PHP-FPM com OPcache otimizado, PHPMyAdmin
- **Padrões Utilizados:** MVC (Model-View-Controller) para módulos de Usuário e Produto, *Prepared Statements* contra SQL Injection, *Soft Delete* (exclusão lógica de produtos) e configuração híbrida via `.env` (`LOCAL` / `DOCKER`).

---

## 🔨 Funcionalidades

- 🔐 **Autenticação de Usuários e Controle de Sessão:**
  - Login seguro validando usuários com situação `Habilitado` e senha criptografada (`MD5`).
  - Proteção de páginas internas (`produto.php`, `produto_alterar.php`, `pedido.php`) com verificação de sessão ativa e rota de encerramento de sessão (`logout.php`).
- 🍕 **Gerenciamento Completo de Produtos (CRUD):**
  - **Cadastro de Produtos:** Registro de nome, categoria, valor unitário (`R$`), referência de foto e informações adicionais vinculado ao usuário logado.
  - **Listagem de Cardápio:** Tabela responsiva exibindo todos os produtos com status `HABILITADO`.
  - **Alteração de Produtos:** Edição completa dos dados cadastrais com atualização automática de data/hora (`NOW()`).
  - **Remoção Assíncrona (AJAX + Soft Delete):** Exclusão lógica (`situacao = 'DESABILITADO'`) sem recarregar a página utilizando `XMLHttpRequest` e retorno em JSON.
- 🧾 **Registro e Listagem de Itens de Pedido:**
  - Adição de itens de pedido contendo produto, quantidade, preço unitário e observações personalizadas (ex.: *"Sem cebola, borda recheada"*).
  - Listagem imediata dos itens lançados com cálculo automático de subtotal por item.
- 🐳 **Ambiente Híbrido Local + Docker:**
  - Alternância rápida entre ambiente Local (`127.0.0.1:3307`) e Docker (`mysql:3306`) através do arquivo `.env`.
  - Banco de dados populado automaticamente no primeiro boot via `bd/init.sql`.

---

## 🎯 Sobre o Projeto

Sistema desenvolvido demonstrando boas práticas de desenvolvimento, arquitetura limpa e organização de código, com foco em escalabilidade e manutenção.

Referência original de estudo: [Playlist — Sistema de pedidos do zero com PHP + MySQL + Bootstrap4](https://www.youtube.com/playlist?list=PLQTbnae5fnDKqJkxhIp7mXETLAR1S7iU2)

---

## 📸 Preview do Projeto

O projeto conta com background em vídeo na tela de login (`./gif/Pizza.mp4`):

<div align="center">
  <video src="./gif/Pizza.mp4" width="600" autoplay loop muted playsinline></video>
</div>

> 💡 Caso seu navegador não renderize o vídeo diretamente no Markdown, o arquivo está disponível em [`./gif/Pizza.mp4`](./gif/Pizza.mp4).

---

## 📁 Documentação do Projeto

Toda a documentação operacional, credenciais de teste e guias de execução passo a passo encontram-se na pasta [`docs/`](./docs):

- 📙 **[`docs/COMO_EXECUTAR.md`](./docs/COMO_EXECUTAR.md)** — Visão geral rápida dos modos de execução, portas e URLs principais.
- 📗 **[`docs/COMO_EXECUTAR_LOCAL.md`](./docs/COMO_EXECUTAR_LOCAL.md)** — Passo a passo completo para rodar localmente com Laragon, XAMPP ou servidor embutido do PHP.
- 📘 **[`docs/COMO_EXECUTAR_DOCKER.md`](./docs/COMO_EXECUTAR_DOCKER.md)** — Guia completo da stack Docker (`nginx`, `app`, `mysql`, `phpmyadmin`) e otimizações de performance.
- 🔐 **[`docs/ACESSOS_TESTES.md`](./docs/ACESSOS_TESTES.md)** — Credenciais dos usuários gerados pelo seed (`admin@restaurante.com` / `atendente@restaurante.com`), rotas e comandos de recarga do banco.

---

## 💻 Comandos

### 🐳 Executando com Docker (Recomendado)

```bash
# 1. Copie o arquivo de ambiente (e ative o bloco # DOCKER no .env)
cp .env.example .env

# 2. Suba os containers em background
docker compose up -d --build

# 3. Acesse no navegador:
# Aplicação: http://localhost:8080
# PHPMyAdmin: http://localhost:8085
```

### 💻 Executando Localmente (Laragon / XAMPP / PHP CLI)

```bash
# 1. Copie o arquivo de ambiente (o bloco # LOCAL já vem ativo por padrão)
cp .env.example .env

# 2. Crie o banco e importe as tabelas e dados iniciais
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql

# 3. Inicie o servidor embutido do PHP
php -S 127.0.0.1:8000

# 4. Acesse no navegador:
# Aplicação: http://127.0.0.1:8000
```

> ⚠️ Estes são comandos básicos. Verifique no projeto arquivos como:
> `README.md`, `docs/COMO_EXECUTAR.md` ou `docs/` para instruções completas.

---

## 🧱 Estrutura do Projeto

```text
sistema-web-restaurante/
├── bd/
│   ├── BancoDados.php          # Conexão PDO dinâmica com suporte a .env (LOCAL e DOCKER)
│   └── init.sql                # Schema completo (usuario, produto, item_pedido) + Seed inicial
├── css/
│   └── style.css               # Estilização da tela de login e vídeo de background
├── docker/
│   ├── nginx/
│   │   └── default.conf        # Configuração Nginx com resolver dinâmico anti-502
│   ├── php/
│   │   ├── fpm-performance.conf# Tuning de workers do PHP-FPM
│   │   └── local.ini           # OPcache, Realpath Cache e sessões em /tmp/sessions
│   └── scripts/
│       └── start-app.sh        # Script de bootstrap rápido do container PHP-FPM
├── docs/
│   ├── ACESSOS_TESTES.md       # Credenciais de teste e validação do ambiente
│   ├── COMO_EXECUTAR.md        # Índice rápido de execução
│   ├── COMO_EXECUTAR_DOCKER.md # Guia detalhado Docker
│   └── COMO_EXECUTAR_LOCAL.md  # Guia detalhado Local (Laragon/XAMPP)
├── gif/
│   └── Pizza.mp4               # Vídeo de fundo da tela de login
├── produto/
│   ├── Produto.php             # Model de Produto (CRUD via PDO)
│   └── ProdutoController.php   # Controller de Produto
├── usuario/
│   ├── Usuario.php             # Model de Usuário (Autenticação e cadastro via PDO)
│   └── UsuarioController.php   # Controller de Usuário (Login e sessão)
├── .dockerignore               # Arquivos ignorados no build da imagem Docker
├── .env.example                # Template padronizado com blocos # LOCAL e # DOCKER
├── .gitignore                  # Proteção de arquivos sensíveis (.env)
├── Dockerfile                  # Imagem PHP 8.2-FPM Alpine otimizada
├── docker-compose.yml          # Orquestração (app, nginx, mysql, phpmyadmin)
├── index.php                   # Tela de Login
├── login.php                   # Processamento de login
├── logout.php                  # Encerramento seguro de sessão
├── produto.php                 # Listagem e cadastro de produtos
├── produto_alterar.php         # Formulário de edição de produto
├── alterar_produto.php         # Processamento de atualização de produto
├── produto_remover.php         # Endpoint JSON para remoção lógica via AJAX
├── pedido.php                  # Tela de lançamento e listagem de itens de pedido
├── cadastrar_pedido.php        # Processamento de inserção de item de pedido
└── conexao_bd.php              # Wrapper de compatibilidade para conexão PDO
```

---

## 📝 Melhorias Futuras

- [ ] Implementar upload físico de imagens para os produtos cadastrados.
- [ ] Adicionar paginação e busca dinâmica com DataTables na listagem de produtos e pedidos.
- [ ] Criar tela de fechamento de pedido agrupando múltiplos itens em uma comanda/mesa.
- [ ] Migrar o hash de senhas de `MD5` para `password_hash()` (Bcrypt/Argon2) com atualização transparente no login.

---

<div align="center">

Feito com ❤️ por Gabriel Martins 🚀

</div>
