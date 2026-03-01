## API TRANSFERÊNCIAS

## Pacotes usados: 
* [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/v7/introduction)

* [Módulo de linguagem pt-BR](https://github.com/lucascudo/laravel-pt-BR-localization)

* [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum)

* [Supervisor](https://laravel.com/docs/10.x/queues#supervisor-configuration)

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

QUEUE_CONNECTION=database
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
php artisan queue:table
php artisan migrate:fresh --seed
```

---

### 7. Acesse a aplicação

Abra no navegador:

```
http://localhost:8000
```

---


## Supervisor (Processamento de Filas)

O container já possui Supervisor configurado para executar:

- php-fpm
- php artisan queue:work

Verificar status:

```bash
supervisorctl status
```

Saída esperada:

```
php-fpm           RUNNING
laravel-worker    RUNNING
```


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
  "payer": 2,
  "payee": 3,
  "value": 1.28
}
```
### Lista Rotas Transações:

Method | Descrição | Rota | Quem pode acessar
:--------- | :------ | :------ | :------
GET | Listar | `/api/transactions` | Próprio usuário
GET | Visualizar | `/api/transactions/{id}` | Próprio usuário
