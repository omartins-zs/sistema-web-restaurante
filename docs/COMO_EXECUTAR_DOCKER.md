# Como Executar com Docker — Sistema Web Restaurante

Guia para executar o sistema utilizando Docker Desktop.

---

## Stack e containers

| Container | Serviço | Função | Porta |
| --- | --- | --- | --- |
| `restaurante_nginx` | `nginx` | Servidor web (Nginx 1.25 Alpine) | `8080` |
| `restaurante_app` | `app` | Aplicação PHP 8.2-FPM com OPcache | Interna (`9000`) |
| `restaurante_mysql` | `mysql` | Banco de dados MySQL 8.0 | `3308` |
| `restaurante_phpmyadmin` | `phpmyadmin` | Administração do banco | `8085` |

---

## 1) Preparar ambiente

```bash
cp .env.example .env
```

Deixe o bloco `DOCKER` ativo e o bloco `LOCAL` comentado no `.env`:

```env
# LOCAL
# APP_ENV=local
# APP_DEBUG=false
# APP_URL=http://127.0.0.1:8000
#
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3307
# DB_DATABASE=restaurante-bd
# DB_USERNAME=root
# DB_PASSWORD=

# DOCKER
APP_ENV=local
APP_DEBUG=false
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=restaurante-bd
DB_USERNAME=restaurante_user
DB_PASSWORD=restaurante_pass
```

> Dentro do Docker, a aplicação conecta ao banco usando `DB_HOST=mysql` e `DB_PORT=3306`. A porta `3308` é mapeada exclusivamente para acesso externo pelo computador host (ex: DBeaver, HeidiSQL).

---

## 2) Subir containers

```bash
docker compose up -d --build
docker compose ps
```

---

## 3) Inicialização e banco de dados

Na primeira execução, o container `mysql` executa automaticamente o script `bd/init.sql` (montado em `/docker-entrypoint-initdb.d/01-init.sql`), criando o banco `restaurante-bd`, as tabelas `usuario`, `produto` e `item_pedido`, e populando os usuários e produtos de teste.

Caso deseje reaplicar o seed manualmente em um volume já existente:

```bash
docker compose exec -T mysql mysql -uroot -prestaurante_pass restaurante-bd < bd/init.sql
```

---

## 4) Otimizações de Performance Aplicadas

O ambiente Docker foi configurado para máxima velocidade em Windows (Docker Desktop):

- **PHP OPcache & Realpath Cache (`docker/php/local.ini`)**: `opcache.memory_consumption=128`, `realpath_cache_size=4096K` e `realpath_cache_ttl=600` para reduzir drasticamente o I/O de leitura em volumes montados no Windows.
- **Sessões em Memória/Tmp (`session.save_path=/tmp/sessions`)**: Armazena sessões dentro do filesystem nativo Linux do container em vez do bind mount do Windows, eliminando travamentos na navegação entre telas.
- **Pool PHP-FPM (`docker/php/fpm-performance.conf`)**: Configurado com `pm = dynamic`, `pm.max_children = 20` e `pm.start_servers = 4` para evitar filas de requisições.
- **Prevenção de 502 no Nginx (`docker/nginx/default.conf`)**: Utiliza `resolver 127.0.0.11 valid=10s` com variável dinâmica de upstream, impedindo que o Nginx fique preso a um IP antigo após reiniciar o container `app`.

---

## 5) Acessos

| Recurso | URL |
| --- | --- |
| Aplicação (Login) | http://localhost:8080 |
| Gestão de Produtos | http://localhost:8080/produto.php |
| Registro de Pedidos | http://localhost:8080/pedido.php |
| PHPMyAdmin | http://localhost:8085 |

### Credenciais de teste

```txt
Perfil: Administrador Restaurante
URL de login: http://localhost:8080/index.php
E-mail: admin@restaurante.com
Senha: 123456
```

```txt
Perfil: Atendente Caixa
URL de login: http://localhost:8080/index.php
E-mail: atendente@restaurante.com
Senha: 123456
```

### PHPMyAdmin

```txt
URL: http://localhost:8085
Servidor: mysql
Usuário: root (ou restaurante_user)
Senha: restaurante_pass
```

---

## 6) Logs e diagnóstico

```bash
docker compose logs -f
docker compose logs -f app
docker compose logs -f nginx
docker compose logs -f mysql
docker compose exec app php -v
```

---

## 7) Parar ou reconstruir

```bash
docker compose down
docker compose up -d --build
```

Para apagar também os volumes (reset completo do banco):

```bash
docker compose down -v
```

> O comando `docker compose down -v` apaga os dados persistidos no volume do banco e recria tudo a partir do `bd/init.sql` no próximo `up`.
