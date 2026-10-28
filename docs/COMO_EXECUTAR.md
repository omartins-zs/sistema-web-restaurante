# Como Executar — Sistema Web Restaurante

Escolha **um** guia conforme seu ambiente:

| Guia | Quando usar | Requisitos no PC |
| --- | --- | --- |
| **[COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md)** | Executar em qualquer máquina com containers | Docker Desktop |
| **[COMO_EXECUTAR_LOCAL.md](COMO_EXECUTAR_LOCAL.md)** | Desenvolver com Laragon, XAMPP ou servidor embutido PHP | PHP e MySQL |
| **[ACESSOS_TESTES.md](ACESSOS_TESTES.md)** | Logins, URLs e fluxos de teste | Qualquer ambiente |

---

## Início rápido

### Local — Laragon ou XAMPP

Ative o bloco `LOCAL` no `.env`, importe o banco `bd/init.sql` e execute:

```bash
cp .env.example .env
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql
php -S 127.0.0.1:8000
```

Aplicação:

http://127.0.0.1:8000

### Docker

Ative o bloco `DOCKER` no `.env` e execute:

```bash
cp .env.example .env
docker compose up -d --build
```

Aplicação:

http://localhost:8080

---

## Logins demo

| Perfil | E-mail | Senha |
| --- | --- | --- |
| Administrador Restaurante | `admin@restaurante.com` | `123456` |
| Atendente Caixa | `atendente@restaurante.com` | `123456` |

---

## URLs principais

| Área | Local | Docker |
| --- | --- | --- |
| Página inicial (Login) | http://127.0.0.1:8000/index.php | http://localhost:8080/index.php |
| Gestão de Produtos | http://127.0.0.1:8000/produto.php | http://localhost:8080/produto.php |
| Registro de Pedidos | http://127.0.0.1:8000/pedido.php | http://localhost:8080/pedido.php |
| PHPMyAdmin | — | http://localhost:8085 |

---

## Outros documentos

- [COMO_EXECUTAR_LOCAL.md](COMO_EXECUTAR_LOCAL.md) — Guia de execução local (Laragon/XAMPP/PHP)
- [COMO_EXECUTAR_DOCKER.md](COMO_EXECUTAR_DOCKER.md) — Guia de execução com Docker Compose
- [ACESSOS_TESTES.md](ACESSOS_TESTES.md) — Credenciais e fluxos de teste
