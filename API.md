# 📡 Documentação da API

Documentação completa dos endpoints disponíveis na API do **Sistema Universitário**.

---

## 🌐 URL Base

```text
http://localhost:8080
```

A API utiliza **Slim Framework 4**, PHP e MySQL. A base de dados utilizada pelo projeto é `SistemaUniversitario`.

---

## 🔐 Autenticação

A autenticação é realizada através de **JWT (JSON Web Token)**.

O login é feito pelo endpoint:

```text
POST /professores/login
```

Depois de realizar o login, os endpoints protegidos de professores exigem o cabeçalho:

```text
Authorization: Bearer {token}
```

Os endpoints protegidos são:

- `GET /professores`
- `GET /professores/count`
- `GET /professores/{id_professor}`
- `PUT /professores/{id_professor}`
- `DELETE /professores/{id_professor}`

O cadastro de professor e o login não exigem token.

---

## 📚 Cursos

### 1. Listar Todos os Cursos

**Endpoint:** `GET /cursos`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "cursos": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/cursos
```

### 2. Buscar Curso por ID

**Endpoint:** `GET /cursos/{id_curso}`

**Parâmetros de URL:**
- `id_curso` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "cursos": {
      "id_curso": 1,
      "nomeCurso": "Informatica"
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/cursos/1
```

### 3. Criar Curso

**Endpoint:** `POST /cursos`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "curso": {
    "id_curso": 5,
    "nomeCurso": "Eletrônica"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso",
  "data": {
    "cursos": [
      {
        "id_curso": 5,
        "nomeCurso": "Eletrônica"
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/cursos \
  -H "Content-Type: application/json" \
  -d '{"curso":{"id_curso":5,"nomeCurso":"Eletrônica"}}'
```

### 4. Atualizar Curso

**Endpoint:** `PUT /cursos/{id_curso}`

**Parâmetros de URL:**
- `id_curso` (int obrigatório)

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "curso": {
    "nomeCurso": "Informática"
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Atualizado com sucesso",
  "data": {
    "cursos": [
      {
        "id_curso": 1,
        "nomeCurso": "Informática"
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/cursos/1 \
  -H "Content-Type: application/json" \
  -d '{"curso":{"nomeCurso":"Informática"}}'
```

### 5. Deletar Curso

**Endpoint:** `DELETE /cursos/{id_curso}`

**Parâmetros de URL:**
- `id_curso` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Excluído com sucesso",
  "data": {
    "cursos": [
      {
        "id_curso": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/cursos/1
```

### 6. Contar Cursos

**Endpoint:** `GET /cursos/count`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "count": 4
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/cursos/count
```

---

## 👨‍🎓 Alunos

### 1. Listar Todos os Alunos

**Endpoint:** `GET /alunos`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "alunos": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/alunos
```

### 2. Buscar Aluno por ID

**Endpoint:** `GET /alunos/{id_aluno}`

**Parâmetros de URL:**
- `id_aluno` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "alunos": {
      "id_aluno": 1,
      "nomeAluno": "Henrique",
      "id_curso": 1
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/alunos/1
```

### 3. Criar Aluno

**Endpoint:** `POST /alunos`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "aluno": {
    "id_aluno": 6,
    "nomeAluno": "João",
    "id_curso": 1
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso",
  "data": {
    "alunos": [
      {
        "id_aluno": 6,
        "nomeAluno": "João",
        "id_curso": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/alunos \
  -H "Content-Type: application/json" \
  -d '{"aluno":{"id_aluno":6,"nomeAluno":"João","id_curso":1}}'
```

### 4. Atualizar Aluno

**Endpoint:** `PUT /alunos/{id_aluno}`

**Parâmetros de URL:**
- `id_aluno` (int obrigatório)

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "aluno": {
    "nomeAluno": "João Atualizado",
    "id_curso": 2
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Atualizado com sucesso",
  "data": {
    "alunos": [
      {
        "id_aluno": 1,
        "nomeAluno": "João Atualizado",
        "id_curso": 2
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/alunos/1 \
  -H "Content-Type: application/json" \
  -d '{"aluno":{"nomeAluno":"João Atualizado","id_curso":2}}'
```

### 5. Deletar Aluno

**Endpoint:** `DELETE /alunos/{id_aluno}`

**Parâmetros de URL:**
- `id_aluno` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Excluído com sucesso",
  "data": {
    "alunos": [
      {
        "id_aluno": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/alunos/1
```

### 6. Contar Alunos

**Endpoint:** `GET /alunos/count`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "count": 5
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/alunos/count
```

---

## 👨‍🏫 Professores

### 1. Realizar Login

**Endpoint:** `POST /professores/login`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "professor": {
    "email": "vitao@escola.com",
    "senha": "Vitao123"
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Login realizado com sucesso",
  "data": {
    "professor": {
      "id_professor": 1,
      "nomeProfessor": "Vitao",
      "email": "vitao@escola.com"
    },
    "token": "eyJ..."
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/professores/login \
  -H "Content-Type: application/json" \
  -d '{"professor":{"email":"vitao@escola.com","senha":"Vitao123"}}'
```

### 2. Listar Todos os Professores

**Endpoint:** `GET /professores`

**Cabeçalhos:**
- `Authorization: Bearer {token}`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "professores": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/professores \
  -H "Authorization: Bearer SEU_TOKEN"
```

### 3. Buscar Professor por ID

**Endpoint:** `GET /professores/{id_professor}`

**Parâmetros de URL:**
- `id_professor` (int obrigatório)

**Cabeçalhos:**
- `Authorization: Bearer {token}`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "professores": {
      "id_professor": 1,
      "nomeProfessor": "Vitao",
      "email": "vitao@escola.com"
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/professores/1 \
  -H "Authorization: Bearer SEU_TOKEN"
```

### 4. Criar Professor

**Endpoint:** `POST /professores`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "professor": {
    "id_professor": 6,
    "nomeProfessor": "Carlos",
    "email": "carlos@escola.com",
    "senha": "123456"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso",
  "data": {
    "professores": [
      {
        "id_professor": 6,
        "nomeProfessor": "Carlos",
        "email": "carlos@escola.com"
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/professores \
  -H "Content-Type: application/json" \
  -d '{"professor":{"id_professor":6,"nomeProfessor":"Carlos","email":"carlos@escola.com","senha":"123456"}}'
```

### 5. Atualizar Professor

**Endpoint:** `PUT /professores/{id_professor}`

**Parâmetros de URL:**
- `id_professor` (int obrigatório)

**Cabeçalhos:**
- `Content-Type: application/json`
- `Authorization: Bearer {token}`

**Corpo da Requisição:**
```json
{
  "professor": {
    "nomeProfessor": "Carlos Atualizado",
    "email": "carlos.novo@escola.com",
    "senha": "123456"
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Atualizado com sucesso",
  "data": {
    "professores": [
      {
        "id_professor": 6,
        "nomeProfessor": "Carlos Atualizado",
        "email": "carlos.novo@escola.com"
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/professores/6 \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer SEU_TOKEN" \
  -d '{"professor":{"nomeProfessor":"Carlos Atualizado","email":"carlos.novo@escola.com","senha":"123456"}}'
```

### 6. Deletar Professor

**Endpoint:** `DELETE /professores/{id_professor}`

**Parâmetros de URL:**
- `id_professor` (int obrigatório)

**Cabeçalhos:**
- `Authorization: Bearer {token}`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Excluído com sucesso",
  "data": {
    "professores": [
      {
        "id_professor": 6
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/professores/6 \
  -H "Authorization: Bearer SEU_TOKEN"
```

### 7. Contar Professores

**Endpoint:** `GET /professores/count`

**Cabeçalhos:**
- `Authorization: Bearer {token}`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "count": 5
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/professores/count \
  -H "Authorization: Bearer SEU_TOKEN"
```

---

## 📖 Disciplinas

### 1. Listar Todas as Disciplinas

**Endpoint:** `GET /disciplinas`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "disciplinas": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/disciplinas
```

### 2. Buscar Disciplina por ID

**Endpoint:** `GET /disciplinas/{id_disciplina}`

**Parâmetros de URL:**
- `id_disciplina` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "disciplinas": {
      "id_disciplina": 1,
      "nomeDisciplina": "POO",
      "id_curso": 1,
      "id_professor": 1,
      "mediaDefinida": 7
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/disciplinas/1
```

### 3. Criar Disciplina

**Endpoint:** `POST /disciplinas`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "disciplina": {
    "id_disciplina": 8,
    "nomeDisciplina": "Banco de Dados",
    "id_curso": 1,
    "id_professor": 1,
    "mediaDefinida": 7
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso",
  "data": {
    "disciplinas": [
      {
        "id_disciplina": 8,
        "nomeDisciplina": "Banco de Dados",
        "id_curso": 1,
        "id_professor": 1,
        "mediaDefinida": 7
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/disciplinas \
  -H "Content-Type: application/json" \
  -d '{"disciplina":{"id_disciplina":8,"nomeDisciplina":"Banco de Dados","id_curso":1,"id_professor":1,"mediaDefinida":7}}'
```

### 4. Atualizar Disciplina

**Endpoint:** `PUT /disciplinas/{id_disciplina}`

**Parâmetros de URL:**
- `id_disciplina` (int obrigatório)

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "disciplina": {
    "nomeDisciplina": "Banco de Dados",
    "id_curso": 1,
    "id_professor": 1,
    "mediaDefinida": 7
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Atualizado com sucesso",
  "data": {
    "disciplinas": [
      {
        "id_disciplina": 1,
        "nomeDisciplina": "Banco de Dados",
        "id_curso": 1,
        "id_professor": 1,
        "mediaDefinida": 7
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/disciplinas/1 \
  -H "Content-Type: application/json" \
  -d '{"disciplina":{"nomeDisciplina":"Banco de Dados","id_curso":1,"id_professor":1,"mediaDefinida":7}}'
```

### 5. Deletar Disciplina

**Endpoint:** `DELETE /disciplinas/{id_disciplina}`

**Parâmetros de URL:**
- `id_disciplina` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Excluído com sucesso",
  "data": {
    "disciplinas": [
      {
        "id_disciplina": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/disciplinas/1
```

### 6. Contar Disciplinas

**Endpoint:** `GET /disciplinas/count`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "count": 7
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/disciplinas/count
```

---

## 📝 Boletins

### 1. Listar Todos os Boletins

**Endpoint:** `GET /boletins`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "boletins": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/boletins
```

### 2. Buscar Boletim por ID

**Endpoint:** `GET /boletins/{id_boletim}`

**Parâmetros de URL:**
- `id_boletim` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "boletins": {
      "id_boletim": 1,
      "nota": 10,
      "frequencia": 95,
      "situacao": "Acima da média",
      "id_aluno": 1,
      "id_disciplina": 1
    }
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/boletins/1
```

### 3. Criar Boletim

**Endpoint:** `POST /boletins`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "boletim": {
    "id_boletim": 6,
    "nota": 8.5,
    "frequencia": 90,
    "situacao": "Acima da média",
    "id_aluno": 1,
    "id_disciplina": 1
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso",
  "data": {
    "boletins": [
      {
        "id_boletim": 6,
        "nota": 8.5,
        "frequencia": 90,
        "situacao": "Acima da média",
        "id_aluno": 1,
        "id_disciplina": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/boletins \
  -H "Content-Type: application/json" \
  -d '{"boletim":{"id_boletim":6,"nota":8.5,"frequencia":90,"situacao":"Acima da média","id_aluno":1,"id_disciplina":1}}'
```

### 4. Atualizar Boletim

**Endpoint:** `PUT /boletins/{id_boletim}`

**Parâmetros de URL:**
- `id_boletim` (int obrigatório)

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "boletim": {
    "nota": 9,
    "frequencia": 95,
    "situacao": "Acima da média",
    "id_aluno": 1,
    "id_disciplina": 1
  }
}
```

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Atualizado com sucesso",
  "data": {
    "boletins": [
      {
        "id_boletim": 1,
        "nota": 9,
        "frequencia": 95,
        "situacao": "Acima da média",
        "id_aluno": 1,
        "id_disciplina": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/boletins/1 \
  -H "Content-Type: application/json" \
  -d '{"boletim":{"nota":9,"frequencia":95,"situacao":"Acima da média","id_aluno":1,"id_disciplina":1}}'
```

### 5. Deletar Boletim

**Endpoint:** `DELETE /boletins/{id_boletim}`

**Parâmetros de URL:**
- `id_boletim` (int obrigatório)

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Excluído com sucesso",
  "data": {
    "boletins": [
      {
        "id_boletim": 1
      }
    ]
  }
}
```

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/boletins/1
```

### 6. Contar Boletins

**Endpoint:** `GET /boletins/count`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Executado com sucesso",
  "data": {
    "count": 5
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/boletins/count
```

---

## 🔄 Códigos HTTP

| Código | Significado |
|--------|-------------|
| 200 | Requisição executada com sucesso |
| 201 | Registro criado com sucesso |
| 302 | Redirecionamento da rota `/` para `/login.html` |
| 400 | Erro de validação dos dados |
| 401 | Acesso não autorizado |
| 404 | Registro não encontrado |
| 500 | Erro interno do servidor |

> **Observação:** os endpoints de exclusão implementados atualmente retornam `200 OK`, e não `204 No Content`.

---

## ❌ Estrutura de Resposta de Erro

Quando ocorre um erro tratado pela API, a resposta segue o formato:

```json
{
  "success": false,
  "message": "Descrição do erro",
  "error": {
    "message": "Detalhes do erro"
  }
}
```

### Exemplos de erros

**400 — Erro na validação de dados:**
```json
{
  "success": false,
  "message": "Erro na validação de dados",
  "error": {
    "message": "O campo 'nomeCurso' é obrigatório!"
  }
}
```

**404 — Registro não encontrado:**
```json
{
  "success": false,
  "message": "Curso não encontrado",
  "error": {
    "message": "Não existe curso com o id 99"
  }
}
```

**401 — Token não informado:**
```json
{
  "success": false,
  "message": "Acesso não autorizado",
  "error": {
    "message": "Token de autenticação não informado"
  }
}
```

**401 — Token inválido ou expirado:**
```json
{
  "success": false,
  "message": "Acesso não autorizado",
  "error": {
    "message": "Token inválido ou expirado"
  }
}
```

---

## 📊 Estrutura de Resposta

### Sucesso

```json
{
  "success": true,
  "message": "Descrição do resultado",
  "data": {}
}
```

### Erro

```json
{
  "success": false,
  "message": "Descrição do erro",
  "error": {}
}
```

---

## 🗄️ Banco de Dados

A API utiliza o banco de dados:

```text
SistemaUniversitario
```

### Tabelas

- `Curso`
- `Aluno`
- `Professor`
- `Disciplina`
- `Boletim`

### Relacionamentos

```text
Curso
 ├── Aluno
 └── Disciplina
       └── Professor

Aluno
 └── Boletim
       └── Disciplina
```

As chaves estrangeiras utilizadas são:

- `Aluno.id_curso` → `Curso.id_curso`
- `Disciplina.id_curso` → `Curso.id_curso`
- `Disciplina.id_professor` → `Professor.id_professor`
- `Boletim.id_aluno` → `Aluno.id_aluno`
- `Boletim.id_disciplina` → `Disciplina.id_disciplina`

---

## 🧪 Testando no Postman

1. **Criar uma Collection**
2. **Definir a variável:**
   - `base_url = http://localhost:8080`
3. **Testar primeiro o login:**
   - `POST {{base_url}}/professores/login`
4. **Copiar o token retornado pela API**
5. **Utilizar o token nos endpoints protegidos de professores:**
   - `Authorization: Bearer SEU_TOKEN`
6. **Testar os demais endpoints de CRUD**
7. **Verificar o código HTTP e o JSON retornado**

---

## 🏗️ Arquitetura da API

A API está organizada em camadas:

```text
Cliente / Frontend
       ↓
     Rotas
       ↓
   Controller
       ↓
     Service
       ↓
      DAO
       ↓
    MySQL
```

### Controller

Recebe a requisição HTTP, obtém os dados enviados pelo cliente e monta a resposta JSON.

### Service

Contém as regras de negócio da aplicação, como validações e verificações de existência dos registros.

### DAO

Responsável pelas operações de acesso ao banco de dados MySQL.

### Model

Representa as entidades utilizadas pela aplicação, como `Aluno`, `Curso`, `Professor`, `Disciplina` e `Boletim`.

### Middleware

Realiza validações antes da execução dos Controllers. Também é utilizado para verificar o token JWT nas rotas protegidas de professores.

---

## 🛠️ Tecnologias Utilizadas

- **PHP**
- **Slim Framework 4**
- **PHP-DI**
- **MySQL**
- **JWT (JSON Web Token)**
- **Composer**
- **HTML**
- **JavaScript**
- **Bootstrap**

---

**Última atualização:** 6 de Outubro de 2026
