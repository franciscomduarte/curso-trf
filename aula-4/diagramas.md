# Aula 0 · Diagramas

## 1. Anatomia de um prompt eficaz

```mermaid
flowchart TB
    P[Prompt estruturado] --> A[Papel<br/>quem a IA deve ser]
    P --> B[Contexto<br/>o que ela precisa saber]
    P --> C[Tarefa<br/>o que fazer, exatamente]
    P --> D[Restrições<br/>o que não fazer / limites]
    P --> E[Formato<br/>como a resposta deve chegar]
    P --> F[Exemplos<br/>few-shot, quando útil]
```

## 2. Ciclo básico: do prompt ao código validado

```mermaid
flowchart LR
    R[Requisito / ideia] --> Pr[Prompt estruturado]
    Pr --> IA[IA gera código]
    IA --> H{Validação<br/>humana}
    H -- reprovado --> Pr
    H -- aprovado --> C[Código aceito no projeto]
```

Este ciclo simples é o embrião do Spec-Driven Development completo, que a Aula 1 formaliza com specs, user stories e critérios de aceitação explícitos no lugar do "requisito/ideia" solto.

## 3. Modelo de dados do SISPROT ao final da Aula 0

```mermaid
erDiagram
    PROTOCOLOS {
        int id PK
        string numero
        string assunto
        string requerente
        date data_abertura
        string status
    }
```

## 4. Estados possíveis do campo `status` (visão antecipada — detalhado na Aula 1)

```mermaid
stateDiagram-v2
    [*] --> Aberto
    Aberto --> Arquivado
```

> Na Aula 0, o único caminho possível é `Aberto → Arquivado` (via `encerrar.php`). Os estados intermediários (`Em Análise`, `Deferido`, `Indeferido`) e as transições entre setores são construídos na Aula 1, a partir de uma especificação formal do fluxo de tramitação.
