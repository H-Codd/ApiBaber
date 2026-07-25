# API de Barbearia

Esta API REST foi desenvolvida em Laravel para oferecer uma experiência completa de busca, seleção e agendamento de barbeiros. O projeto permite que usuários cadastrem-se, façam autenticação, pesquisem barbeiros, favoritem profissionais e marquem horários para atendimento.

## Visão Geral

A API foi pensada para servir como backend de uma aplicação mobile ou web para barbearias, com foco em:

- Seleção e listagem de barbeiros
- Favoritar barbeiros
- Sistema de autenticação
- Pesquisa de barbeiros por nome
- Agendamento de horários
- Upload e tratamento de imagens de avatar com Intervention Image

## Tecnologias Utilizadas

- Laravel 13
- PHP 8.3
- JWT para autenticação de usuários
- Sanctum para integração com o ecossistema Laravel
- Intervention Image para manipulação de imagens

## Funcionalidades Principais

### Autenticação

A API possui rotas para:

- Cadastro de usuário
- Login
- Logout
- Refresh de token

### Barbeiros

É possível:

- Listar barbeiros
- Visualizar detalhes de um barbeiro específico
- Buscar barbeiros por nome
- Verificar disponibilidade de horários
- Agendar um horário com um barbeiro

### Favoritos e agenda

Os usuários podem:

- Favoritar barbeiros
- Consultar a lista de favoritos
- Visualizar agendamentos realizados

## Endpoints Principais

### Autenticação

- POST /user — criar conta
- POST /auth/login — autenticar usuário
- POST /auth/logout — encerrar sessão
- POST /auth/refresh — renovar token

### Barbeiros

- GET /babers — listar barbeiros
- GET /babers/{id} — detalhes do barbeiro
- GET /search?q=nome — pesquisar barbeiros
- POST /barber/{id}/appointment — agendar horário

### Usuário

- GET /user — consultar dados do usuário
- PUT /user — atualizar dados
- PUT /user/avatar — atualizar avatar
- GET /user/favorites — listar favoritos
- POST /user/favorite — favoritar/desfavoritar barbeiro
- GET /user/appointments — listar agendamentos

## Instalação

1. Clone o repositório
2. Instale as dependências:

```bash
composer install
npm install
```

3. Configure o ambiente:

```bash
cp .env.example .env
php artisan key:generate
```

4. Execute as migrations:

```bash
php artisan migrate
```

5. Inicie o projeto:

```bash
php artisan serve
```

## Exemplo de uso

Para acessar endpoints protegidos, envie o token no cabeçalho de autorização:

```http
Authorization: Bearer {token}
```

## Observações

A API utiliza autenticação baseada em JWT e também faz uso do ecossistema Laravel Sanctum, além de processamento de imagens com Intervention Image para o cadastro e atualização de avatares.

## Licença

Este projeto é distribuído sob a licença MIT.
