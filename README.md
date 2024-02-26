## API TRANSFERÊNCIAS

### Instalação: 

* Você precisará do PHP instalado em seu computador, [BAIXE AQUI](https://www.php.net/downloads). 
* Na raiz do projeto use o comando `composer install`. 
* No arquivo `.ENV` edite o campo `DB_CONNECTION` e coloque os dados do seu banco de dados.
* No arquivo `.ENV` edite o campo `MAIL_MAILER` e coloque os dados do seu servidor de email.
* Use o comando `php artisan migrate:fresh --seed` para fazer as migrações.
* Use o comando `php artisan serve` para rodar em seu servidor.
* Navegue para `http://localhost:8000`. O aplicativo será carregado automaticamente.

#### Observações:
* Dentro da pasta DOCS do projeto existe o arquivo para usar no Postman
* Ao propagar o banco ele já vem com usuários cadastrados:

```
Tipo: Cliente Comum
Email: client@email.com
Senha: 12345678
```
```
Tipo: Lojista
Email: shopkeeper@email.com
Senha: 12345678
```
* Como o foco não é cadastro de usuários dicidi criar um seed para adiantar tabalho.

### Lista Rotas Auth:
Method   | Descrição | Rota
:--------- | :------ | :------
POST | Login | `localhost:8000/api/login`
POST | Logout| `localhost:8000/api/logout`

### Body Login:
```
{
    "email": "client@email.com",
    "password": "12345678"
}
```

### Rota Transferência:
Method   | Descrição | Rota
:--------- | :------ | :------
POST | Lista de tasks | `localhost:8000/api/transfers`

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
