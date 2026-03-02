# Gestão do SISU

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)
![Eloquent](https://img.shields.io/badge/Eloquent_ORM-12.4-FF2D20?logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-18-4169E1?logo=postgresql&logoColor=white)
![Nginx](https://img.shields.io/badge/Nginx-Reverse_Proxy-009639?logo=nginx&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-CDN-06B6D4?logo=tailwindcss&logoColor=white)

Simulação acadêmica do sistema de gerenciamento do **SISU** (Sistema de Seleção Unificada), com CRUD completo de candidatos, cursos e edições, além de geração de listas de convocação com distribuição por cotas.

</div>

---

## Índice

- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Arquitetura](#arquitetura)
- [Pré-requisitos](#pré-requisitos)
- [Instalação](#instalação)
- [Uso](#uso)
- [Estrutura do Projeto](#estrutura-do-projeto)
- [Banco de Dados](#banco-de-dados)

## Funcionalidades

| Módulo         | Descrição                                                                                                                              |
| -------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| **Candidatos** | Cadastro com nome, CPF (com validação de dígitos verificadores), data de nascimento, categoria de cota, curso, edição e nota (0–1000). |
| **Cursos**     | CRUD de cursos oferecidos pela instituição.                                                                                            |
| **Edições**    | Gerenciamento de edições do SISU com distribuição de vagas por curso e por categoria de cota.                                          |
| **Convocação** | Geração de listas de convocação com ranking por nota, respeitando o número de vagas por categoria e fator multiplicador configurável.  |

### Categorias de Cota

O sistema implementa 6 modalidades de concorrência:

- Ampla Concorrência
- PPI – Escola Pública – Baixa Renda
- Escola Pública – Baixa Renda
- PPI – Escola Pública
- Escola Pública
- Pessoa com Deficiência

## Tecnologias

| Camada              | Tecnologia                                      |
| ------------------- | ----------------------------------------------- |
| **Back-end**        | PHP 8.2+ com Eloquent ORM (illuminate/database) |
| **Front-end**       | Tailwind CSS via CDN com tema de cores gov.br   |
| **Banco de dados**  | PostgreSQL 18                                   |
| **Servidor web**    | Nginx (reverse proxy + FastCGI)                 |
| **Containerização** | Docker & Docker Compose                         |

## Arquitetura

O projeto segue o padrão **MVC** sem framework completo, utilizando apenas o Eloquent ORM do Laravel como dependência externa:

```
Request → Nginx → PHP-FPM → index.php (Router)
                                 ↓
                            Controller
                            ↙        ↘
                      Service         View
                         ↓
                       Model
                         ↓
                    PostgreSQL
```

- **Router**: roteamento por segmentos de URL (`/{controller}/{action}/{id}`)
- **Controllers**: herdam de um `Controller` base com helpers de view, redirect, flash messages e abort
- **Requests**: validação e sanitização de input (trim + htmlspecialchars)
- **Services**: lógica de negócio isolada dos controllers
- **Models**: Eloquent com relacionamentos (BelongsTo, HasMany, BelongsToMany)
- **Views**: PHP puro com layout via partials (header, footer, alert)

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/) e [Docker Compose](https://docs.docker.com/compose/install/)

## Instalação

1. **Clone o repositório:**

```bash
git clone https://github.com/elianmagno/gestao-sisu.git
cd gestao-sisu
```

2. **Crie o arquivo `.env`** na raiz do projeto:

```env
SISU_DB_USER=postgres
SISU_DB_PASS=postgres
SISU_DB_NAME=sisu
```

3. **Suba os containers:**

```bash
docker compose up -d --build
```

O Docker Compose irá:

- Inicializar o PostgreSQL com o schema e dados de exemplo (~900 candidatos)
- Instalar as dependências PHP via Composer
- Configurar o Nginx como reverse proxy

4. **Acesse a aplicação:**

```
http://localhost
```

## Uso

### Página Inicial

A home apresenta uma visão geral do sistema com acesso direto aos 4 módulos.

### Fluxo típico

1. **Cursos** → Cadastre os cursos da instituição
2. **Edições** → Crie uma edição do SISU e distribua as vagas por curso e categoria
3. **Candidatos** → Inscreva candidatos vinculando-os a um curso e edição
4. **Convocação** → Gere a lista de convocação selecionando curso, edição e fator multiplicador

### Convocação

O sistema gera a lista de convocados aplicando:

- **Ranking por nota** (ordem decrescente) dentro de cada categoria
- **Fator multiplicador** × vagas = total de candidatos listados
- Candidatos dentro do número de vagas: **Classificado/Aprovado**
- Candidatos excedentes: **Não Classificado**

## Estrutura do Projeto

```
├── docker-compose.yml          # Orquestração dos serviços
├── Dockerfile                  # Imagem PHP-FPM
├── php.ini                     # Configurações do PHP
├── nginx/
│   └── nginx.conf              # Configuração do Nginx
├── postgres/
│   ├── Dockerfile              # Imagem PostgreSQL com locale pt_BR
│   └── initdb/
│       ├── 01-criar-tabelas.sql    # Schema do banco
│       └── 02-popular_base.sql     # Dados de exemplo
└── app/
    ├── composer.json           # Dependências PHP
    ├── index.php               # Entry point e router
    ├── Controllers/            # Controllers MVC
    ├── Models/                 # Models Eloquent
    ├── Requests/               # Validação de formulários
    ├── Services/               # Lógica de negócio
    ├── Traits/                 # Traits reutilizáveis
    ├── public/images/          # Assets estáticos (logo, favicon)
    └── views/                  # Views PHP
        ├── partials/           # Header, footer, alertas
        ├── home/               # Página inicial
        ├── errors/             # Páginas de erro
        ├── candidato/          # Views de candidatos
        ├── curso/              # Views de cursos
        ├── edicao/             # Views de edições
        └── convocacao/         # Views de convocação
```

## Banco de Dados

### Diagrama de tabelas

```
┌─────────────┐       ┌──────────────┐       ┌─────────────┐
│   cursos    │       │ curso_edicao │       │   edicoes   │
├─────────────┤       ├──────────────┤       ├─────────────┤
│ id (PK)     │◄──────│ curso_id(FK) │       │ id (PK)     │
│ nome        │       │ edicao_id(FK)│──────►│ nome        │
└──────┬──────┘       │ vagas_ac     │       └──────┬──────┘
       │              │ vagas_ppi_br │              │
       │              │ vagas_pub_br │              │
       │              │ vagas_ppi_pub│              │
       │              │ vagas_pub    │              │
       │              │ vagas_def    │              │
       │              └──────────────┘              │
       │                                            │
       │         ┌──────────────┐                   │
       └────────►│ candidatos   │◄──────────────────┘
                 ├──────────────┤
                 │ id (PK)      │
                 │ nome         │
                 │ cpf          │
                 │ data_nasc    │
                 │ categoria    │
                 │ curso_id(FK) │
                 │ edicao_id(FK)│
                 │ nota (0-1000)│
                 └──────────────┘
```

---

<div align="center">
  <sub>Desenvolvido como projeto acadêmico — Simulação do SISU</sub>
</div>
