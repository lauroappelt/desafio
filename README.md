# Desafio PHP

### Pré-requisitos

* Docker
* Docker compose

### Instalação

Passo a passo para você rodar este projeto localmente:

* crie um fork e clone na sua máquina
* siga os comandos a baixo para subir a aplicação
```
$ cp .env.example .env
$ docker compose up -d
$ docker exec desafio-app composer install
$ docker exec desafio-app php artisan key:generate
$ docker exec desafio-app php artisan migrate:refresh --seed
$ docker exec desafio-app php artisan migrate:refresh --seed --env=testing
```

Após isso a aplicação está disponível em [http://localhost:8989](http://localhost:8989)


## Sobre o desafio

Este teste técnico propoe em criar um mini sistema de transfêrencias bancárias entre dois usuários

## Requisitos definidos

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema.

* Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

- Lojistas só recebem transferências, não enviam dinheiro para ninguém.

* Validar se o usuário tem saldo antes da transferência.

- Validar o serviço autorizador externo.

* Em casso de erro tudo deve ser revertido, ou seja, o dinheiro voltar para a conta de origem.

- Ao finalizar trânferencia o lojista ou usuário deve receber uma notificação.


## Tecnologias utilizadas

* Docker | Docker Compose
* PHP 8.2
* Laravel 10.x
* Nginx
* Postgres

## Observações importantes

Como descrito na documentação do desafio, os itens de autenticação e cadastro dos usuários não são avaliados. Por este motivo não implementei um CRUD completo de usuários e a autenticação.

## Modelagem de dados

Por se tratar de um sistema bancário, escolhi representar os valores em inteiros (centavos): 100 = R$ 1,00. 

Escolhi utilizar UUID como chaves primárias, por se tratar de operações de transfêrencias bancárias.

```markdown
# Tabela: users

| Coluna      | Tipo          | Constraint
|-------------|---------------|-------------
| id          | UUID          | PK
| name        | VARCHAR       |
| identifier  | VARCHAR       | UK
| email       | VARCHAR       | UK
| password    | VARCHAR       |
| user_type   | VARCHJAR      |

# Tabela: wallets

| Coluna      | Tipo          | Constraint
|-------------|---------------|----------
| id          | UUID          | PK      
| user_id     | UUID          | FK (users.id)  
| balance     | BIGINT        |

# Tabela: transactions

| Coluna      | Tipo          | Constraint
|-------------|---------------|----------
| id          | UUID          | PK      
| payer       | UUID          | FK (wallets.id)
| payee       | UUID          | FK (wallets.id)
| ammount     | BIGINT        | 

```

## Endpoints
#### `POST /api/user`
- Cria um novo usuário e sua carteira.

#### `GET /api/user`
- Lista todos usuários com sua carteira

#### `PUT /api/user`
- Adiciona saldo a carteira do usuário

#### `POST /api/transaction`
- Realiza a trânsferencia entre carteiras

Veja a documentação completa aqui [https://documenter.getpostman.com/view/17234193/2s9YXk41sv#f7ff9a27-d268-46fc-9831-205525901979](https://documenter.getpostman.com/view/17234193/2s9YXk41sv#f7ff9a27-d268-46fc-9831-205525901979)