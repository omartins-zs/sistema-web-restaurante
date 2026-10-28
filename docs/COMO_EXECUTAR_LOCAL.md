# Como Executar Localmente — Sistema Web Restaurante

Guia para rodar **sem Docker**, no **Laragon**, **XAMPP** ou com `php -S 127.0.0.1:8000`.

> **Não quer instalar PHP ou MySQL localmente?** Use [COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md) — basta Docker Desktop, em qualquer Windows, Mac ou Linux.

---

## Requisitos

Para rodar localmente, você **não precisa** de uma versão específica do Laragon.

O essencial é **PHP** compatível com **PDO MySQL** e um servidor **MySQL** ativo.

| Ferramenta | Obrigatório? | Versão mínima |
| --- | --- | --- |
| **PHP** | Sim | 7.4+ / 8.2+ |
| **MySQL** | Sim | 8.0+ (ou MariaDB 10.4+) |

Extensões PHP necessárias: `pdo`, `pdo_mysql`, `mbstring`, `intl`, `zip`, `bcmath`.

### Ambiente de referência (máquina de desenvolvimento)

Stack usada na elaboração deste projeto — **não é requisito fixo**, só referência do que já foi testado:

| Ferramenta | Versão |
| --- | --- |
| **Laragon** | **6.0.0** |
| PHP (via Laragon) | 8.4.6 |
| Composer | 2.8.12 |
| Laravel (no projeto) | 13.15.0 |
| **Node.js** | **22.14.0+** |
| **NPM** | **11.4.2+** |

Para conferir no seu computador:

```bash
php -v
mysql --version
```

---

## 1) Preparar ambiente

### 1.1 Clonar ou acessar o projeto

```bash
cd c:/Projetos/sistema-web-restaurante
```

### 1.2 Copiar variáveis de ambiente

```bash
cp .env.example .env
```

No PowerShell:

```powershell
Copy-Item .env.example .env
```

### 1.3 Ativar o ambiente local

Deixe o bloco `LOCAL` ativo e o bloco `DOCKER` comentado no `.env`:

```env
# LOCAL
APP_ENV=local
APP_DEBUG=false
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=restaurante-bd
DB_USERNAME=root
DB_PASSWORD=

# DOCKER
# APP_ENV=local
# APP_DEBUG=false
# APP_URL=http://localhost:8080
#
# DB_CONNECTION=mysql
# DB_HOST=mysql
# DB_PORT=3306
# DB_DATABASE=restaurante-bd
# DB_USERNAME=restaurante_user
# DB_PASSWORD=restaurante_pass
```

### 1.4 Criar o banco de dados e carregar tabelas iniciais

Crie o banco pelo HeidiSQL, PHPMyAdmin ou execute o script SQL incluído no projeto:

```sql
CREATE DATABASE `restaurante-bd`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Para importar todas as tabelas (`usuario`, `produto`, `item_pedido`) e os dados de teste via terminal:

```bash
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql
```

> No ambiente local, utilizar MySQL na porta **3307**, usuário `root` e senha vazia (a classe `BancoDados` também realiza fallback automático para a porta `3306` caso a `3307` não esteja ativa).

---

## 2) Instalar dependências

O projeto utiliza **PHP nativo (MVC)** e **Bootstrap 4 via CDN**, não exigindo instalação de pacotes externos via Composer ou NPM.

---

## 3) Inicialização do banco de dados

Para recriar ou atualizar os dados iniciais de teste a qualquer momento:

```bash
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql
```

---

## 4) Rodar aplicação

```bash
php -S 127.0.0.1:8000
```

Aplicação:

http://127.0.0.1:8000

---

## 5) Filas e workers

O projeto não utiliza filas em background, portanto não exige worker adicional.

---

## 6) Acessos

| Recurso | URL |
| --- | --- |
| Página inicial / Login | http://127.0.0.1:8000/index.php |
| Gestão de Produtos | http://127.0.0.1:8000/produto.php |
| Registro de Pedidos | http://127.0.0.1:8000/pedido.php |

### Credenciais de teste

```txt
Perfil: Administrador Restaurante
URL de login: http://127.0.0.1:8000/index.php
E-mail: admin@restaurante.com
Senha: 123456
```

```txt
Perfil: Atendente Caixa
URL de login: http://127.0.0.1:8000/index.php
E-mail: atendente@restaurante.com
Senha: 123456
```

---

## 7) Comandos úteis

```bash
php -v
php -m
php -S 127.0.0.1:8000
```

---

## 8) Problemas comuns

### Banco não conecta

Verifique no `.env` se o host e a porta correspondem ao seu MySQL local:

```env
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=restaurante-bd
DB_USERNAME=root
DB_PASSWORD=
```

### Tabelas não encontradas

Importe o script de estrutura e seeds do projeto:

```bash
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql
```

---

## Próximo passo

Para ambiente containerizado, consulte [COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md).
