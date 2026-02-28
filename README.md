## API TRANSFERÊNCIAS

## Pacotes usados: 
* [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v7/introduction)

* [Módulo de linguagem pt-BR](https://github.com/lucascudo/laravel-pt-BR-localization)

* [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)

## Instalação: 

### 1. Suba os containers

Na raiz do projeto execute:

```bash
docker compose up -d --build
```

Verifique se os containers estão rodando:

```bash
docker ps
```

---

### 2. Instale as dependências do Laravel

Entre no container da aplicação:

```bash
docker exec -it wallet_app bash
```

Dentro do container:

```bash
composer install
```

---

### 3. Configure o ambiente

Se o arquivo `.env` não existir:

```bash
cp .env.example .env
```

Edite o `.env` com as configurações do banco:

```env
DB_CONNECTION=mysql
DB_HOST=wallet_mysql
DB_PORT=3306
DB_DATABASE=wallet
DB_USERNAME=wallet
DB_PASSWORD=wallet
```

Configure o servidor de e-mail:

```env
MAIL_MAILER=smtp
MAIL_HOST=seu_servidor_smtp
MAIL_PORT=587
MAIL_USERNAME=seu_usuario
MAIL_PASSWORD=sua_senha
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu_email@dominio.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

### 4. Gere a  chave da aplicação

```bash
php artisan key:generate
```

---

### 5. Ajuste as permissões

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

### 6. Rode as migrations e seeders

```bash
php artisan migrate:fresh --seed
```

---

### 7. Acesse a aplicação

Abra no navegador:

```
http://localhost:8000
```

---


#### Observações:
* Dentro da pasta DOCS do projeto existe o arquivo para usar no Postman
* Ao propagar o banco ele já vem com usuários cadastrados:

```
Tipo: Super Admin 
Email: superadmin@email.com
Senha: 12345678
```
```
Tipo: Cliente 
Email: customer@email.com
Senha: 12345678
```
```
Tipo: Lojista
Email: shopkeeper@email.com
Senha: 12345678
```

### Lista Rotas Auth:
Method   | Descrição | Rota
:--------- | :------ | :------
POST | Login | `/api/login`
POST | Logout| `/api/logout`

### Body Login:
```
{
    "email": "customer@email.com",
    "password": "12345678"
}
```

### Lista Rotas Usuarios:

Method | Descrição | Rota | Quem pode acessar
:--------- | :------ | :------ | :------
POST | Registrar | `/api/register` | Público
GET | Listar | `/api/users` | super_admin
GET | Visualizar | `/api/users/{id}` | Próprio usuário ou super_admin
PUT / PATCH | Atualizar | `/api/users/{id}` | Próprio usuário ou super_admin
DELETE | Desativar | `/api/users/{id}` | Próprio usuário ou super_admin

### Rota Transferência:
Method   | Descrição | Rota
:--------- | :------ | :------
POST | Lista de tasks | `/api/transfers`

### Body Transferência:
```
{
    "value" : 12.65,
    "payee" : 2
}
```
#### Observações:
* Na hora da transferência ele já pega o saldo do usuário logado

### Comando rodar os testes:
```
php artisan test
```
#### Observações Finais:
* Embora possuo conhecimento em Docker, encontrei dificuldades na criação das imagens necessárias para executar o projeto.
* Se este teste não atender aos critérios para a vaga de nível Pleno, gostaria de ser considerado para avaliação em uma posição de nível Júnior, caso surja uma oportunidade adequada.
