# 🔐 Acessos e Dados de Teste

Utilize as credenciais abaixo para testar as diferentes visões e permissões do sistema. Todos os usuários e registros foram gerados automaticamente via script de inicialização e seed (`bd/init.sql`).

## 1. Acesso ao Sistema (Usuários de Teste)

| Perfil | E-mail / Usuário | Senha | Permissão / Detalhes |
| --- | --- | --- | --- |
| Administrador Restaurante | `admin@restaurante.com` | `123456` | Acesso completo ao gerenciamento de cardápio (cadastro, listagem, edição e remoção lógica de produtos) e registro de itens de pedidos. |
| Atendente Caixa | `atendente@restaurante.com` | `123456` | Acesso operacional ao painel de produtos e lançamento de itens de pedidos no balcão/caixa. |

## 2. URLs Principais

| Ambiente | Aplicação (Home) | Login / Painel |
| --- | --- | --- |
| **Docker** | `http://localhost:8080` | `http://localhost:8080/index.php` |
| **Local** (`php -S 127.0.0.1:8000`) | `http://127.0.0.1:8000` | `http://127.0.0.1:8000/index.php` |

## 3. Páginas e Módulos do Sistema

| Item | Link (Exemplo Docker) |
| --- | --- |
| Tela de Login (Home) | `http://localhost:8080/index.php` |
| Gestão de Produtos (Cardápio) | `http://localhost:8080/produto.php` |
| Edição de Produto | `http://localhost:8080/produto_alterar.php?cod_prod=1` |
| Registro de Itens de Pedido | `http://localhost:8080/pedido.php` |
| PHPMyAdmin (Gerenciador do Banco) | `http://localhost:8085` |

## 4. Validação do Acesso

Validação da saúde da aplicação no ambiente de desenvolvimento:

| Verificação | Resultado Esperado |
| --- | --- |
| Containers (`restaurante_mysql`, `restaurante_app`, `restaurante_nginx`, `restaurante_phpmyadmin`) | Saudáveis / Rodando |
| Tela de login principal (`/index.php`) | HTTP `200` |
| Login com usuário de teste gerado pelo seed | Redirecionamento para `produto.php` |

## 5. Carregar Dados de Teste

Caso o banco de dados seja apagado ou precise ser resetado, basta rodar os comandos abaixo para recriar todas essas credenciais e os registros iniciais da plataforma.

**Com Docker:**
```bash
docker compose exec -T mysql mysql -uroot -prestaurante_pass restaurante-bd < bd/init.sql
```

**Rodando Localmente (Sem Docker):**
```bash
mysql -h 127.0.0.1 -P 3307 -u root < bd/init.sql
```

---

### 📝 Observações:
- O banco de dados é alimentado com produtos iniciais (pizzas, massas e bebidas) e itens de pedido vinculados a esses usuários para facilitar a visualização e validação imediata dos fluxos.
- Use estas credenciais **apenas** em ambiente local ou Docker de desenvolvimento.
