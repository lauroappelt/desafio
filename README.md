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
$ docker exec desafio-php composer install
$ docker exec desafio-php php artisan migrate:refresh --seed
$ docker exec desafio-php php artisan migrate:refresh --seed --env=testing
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

## Endpoints
#### `POST /api/user`

- **Descrição:** Cria um novo usuário e sua carteira.

- **Parâmetros de entrada:**
  - `name`: Nome do usuário.
  - `identifier`: Identificador do usuário (CPF ou CNPJ).
  - `email`: E-mail do usuário.
  - `password`: Senha do usuário.
  - `user_type`: Tipo do usuário (common ou shopkeeper).

- **Exemplo de Requisição:**
  ```bash
  curl -X POST -H "Content-Type: application/json" -d '{"name": "Luis Suarez", "identifier": "878.035.500-53", "email": "luis.suares@mycompany.com", "password": "1234", "user_type": "common"}' http://127.0.0.1:8989/api/user

- **Resposta com sucesso**
  ```
  { 
    "message": "User registered!",
    "data": {
            "name": "Juis Suares",
            "identifier": "878.035.500-53",
            "email": "luis.suares@mycompany.com",
            "user_type": "common",
            "id": "a57d32b8-4951-42d8-baed-18680c32ede7",
            "wallet": {
                "user_id": "a57d32b8-4951-42d8-baed-18680c32ede7",
                "balance": 0,
                "id": "ef931103-13bc-4525-a804-ce440b8d92d7"
            }
        }
    }

#### `GET /api/user`

- **Descrição:** Lista os usuários cadastrados.

- **Parâmetros de entrada:** Nenhum.

- **Exemplo de Requisição:**
  ```bash 
  curl -X GET -H "Content-Type: application/json"  http://127.0.0.1:8989/api/user

- **Resposta com sucesso**
  ```
    {
        "data": [
            {
                "id": "d49304ec-4298-4d00-b32f-a08e8983bb2e",
                "name": "Luis Suares",
                "identifier": "878.035.500-53",
                "email": "luis.suares@mycompany.com",
                "user_type": "common",
                "created_at": "2023-11-11T21:54:52.000000Z",
                "updated_at": "2023-11-11T21:54:52.000000Z",
                "wallet": {
                    "id": "92b6b14f-72d6-4665-9602-b9ae98a8adee",
                    "user_id": "d49304ec-4298-4d00-b32f-a08e8983bb2e",
                    "balance": 0,
                    "created_at": "2023-11-11T21:54:52.000000Z",
                    "updated_at": "2023-11-11T21:54:52.000000Z"
                }
            }
        ]
    }
