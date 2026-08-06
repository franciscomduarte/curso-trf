# Aula 1 · Demonstração final — material do instrutor (Claude Code no SISPROT real)

> Mostrar somente na demonstração final, depois do tempo de execução do desafio. Material de apoio para você rodar ao vivo — não distribuir à turma antes disso.

## Antes da aula

1. Confirme que o XAMPP (Apache + MySQL) está rodando e que o banco `sisprot` existe (Aula 0).
2. Copie `aula-1/codigo/` (o estado ao final da Aula 0 — CRUD completo, sem tramitação) para uma pasta de trabalho separada, se preferir não editar o material de referência diretamente.
3. Abra um terminal dentro dessa pasta e rode `claude`.

## As 3 specs → prompts, em sequência (os mesmos que estão na aula)

### Spec 1 → Prompt 1 — histórico de movimentações + setor atual

> **Como** servidor de qualquer setor, **quero** ver o histórico completo de um protocolo, **para que** eu entenda por onde ele já passou antes de agir.

```
[PAPEL] Você é um desenvolvedor PHP sênior, especialista em sistemas administrativos
para o setor público.

[CONTEXTO] Este é o SISPROT: PHP puro + MySQL, com PDO e prepared statements. A
tabela "protocolos" já existe (index.php, protocolo_form.php, encerrar.php).

[TAREFA] Adicione uma coluna "setor_atual" (texto, valor padrão "Recepção") à
tabela protocolos, e uma nova tabela "protocolo_historico" (protocolo_id,
status_anterior, status_novo, setor, data). Toda mudança de status deve gravar
uma linha no histórico.

[RESTRIÇÕES] Não altere nada que já funciona. Sempre usar prepared statements.
Não usar frameworks.

[FORMATO] SQL primeiro (ALTER TABLE + CREATE TABLE), depois cada arquivo
alterado, com o nome antes do código.
```

**Resultado esperado — SQL:**

```sql
ALTER TABLE protocolos
  ADD COLUMN setor_atual VARCHAR(60) NOT NULL DEFAULT 'Recepção' AFTER status;

CREATE TABLE IF NOT EXISTS protocolo_historico (
  id INT AUTO_INCREMENT PRIMARY KEY,
  protocolo_id INT NOT NULL,
  status_anterior VARCHAR(20) NOT NULL,
  status_novo VARCHAR(20) NOT NULL,
  setor VARCHAR(60) NOT NULL,
  data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (protocolo_id) REFERENCES protocolos(id) ON DELETE CASCADE
);
```

---

### Spec 2 → Prompt 2 — transições controladas, com validação

> **Como** responsável por manter a integridade do fluxo, **quero** que só as transições previstas sejam aceitas, **para que** nenhum protocolo pule etapas do processo.

```
[PAPEL] Você é um desenvolvedor PHP sênior, especialista em sistemas administrativos
para o setor público.

[CONTEXTO] O SISPROT agora tem protocolo_historico e a coluna setor_atual (Prompt
1). As transições válidas são: Aberto → Em Análise; Em Análise → Deferido; Em
Análise → Indeferido; Deferido → Arquivado; Indeferido → Arquivado.

[TAREFA] Crie tramitar.php: recebe id do protocolo e novo status, valida se a
transição é permitida a partir do status atual, grava o histórico e atualiza o
status. Se a transição não for permitida, não altera nada e mostra uma mensagem
de erro.

[RESTRIÇÕES] Não permita nenhuma transição fora da lista acima. Sempre usar
prepared statements. Não usar frameworks.

[FORMATO] Só o arquivo tramitar.php, comentado indicando onde fica a validação
das transições.
```

**Resultado esperado — `tramitar.php`:**

```php
<?php
require 'conexao.php';

// Mapa de transições permitidas: status atual => status seguintes possíveis
$transicoesValidas = [
    'Aberto'      => ['Em Análise'],
    'Em Análise'  => ['Deferido', 'Indeferido'],
    'Deferido'    => ['Arquivado'],
    'Indeferido'  => ['Arquivado'],
];

$id = $_POST['id'] ?? null;
$novoStatus = $_POST['novo_status'] ?? null;

if (!$id || !$novoStatus) {
    header('Location: index.php?msg=erro_tramitacao');
    exit;
}

$stmt = $pdo->prepare('SELECT status, setor_atual FROM protocolos WHERE id = ?');
$stmt->execute([$id]);
$protocolo = $stmt->fetch();

if (!$protocolo) {
    header('Location: index.php?msg=erro_tramitacao');
    exit;
}

$statusAtual = $protocolo['status'];
$permitidas = $transicoesValidas[$statusAtual] ?? [];

// Validação central: se a transição pedida não estiver entre as permitidas
// a partir do status atual, nada é alterado.
if (!in_array($novoStatus, $permitidas, true)) {
    header('Location: index.php?msg=transicao_invalida');
    exit;
}

$pdo->beginTransaction();

$stmt = $pdo->prepare('INSERT INTO protocolo_historico (protocolo_id, status_anterior, status_novo, setor) VALUES (?, ?, ?, ?)');
$stmt->execute([$id, $statusAtual, $novoStatus, $protocolo['setor_atual']]);

$stmt = $pdo->prepare('UPDATE protocolos SET status = ? WHERE id = ?');
$stmt->execute([$novoStatus, $id]);

$pdo->commit();

header('Location: index.php?msg=tramitado');
exit;
```

---

### Spec 3 → Prompt 3 — tela de tramitação, com histórico visível

> **Como** servidor do setor responsável, **quero** ver as próximas transições possíveis e o histórico completo na tela do protocolo, **para que** eu não precise adivinhar o que posso fazer.

```
[PAPEL] Você é um desenvolvedor PHP sênior, especialista em sistemas administrativos
para o setor público.

[CONTEXTO] tramitar.php (Prompt 2) já processa a mudança de status. index.php
lista os protocolos.

[TAREFA] Na listagem (index.php), mostre o setor_atual como coluna, e troque o
link "Arquivar" por botões com as próximas transições válidas para aquele status
(apontando para tramitar.php). Na tela de edição (protocolo_form.php), exiba o
histórico completo do protocolo, do mais recente para o mais antigo.

[RESTRIÇÕES] Não altere as colunas já existentes na listagem. Sempre usar
prepared statements. Não usar frameworks.

[FORMATO] Para cada arquivo alterado, o nome antes do código.
```

**Resultado esperado — trecho de `index.php`:**

```php
<?php
$transicoesValidas = [
    'Aberto'      => ['Em Análise'],
    'Em Análise'  => ['Deferido', 'Indeferido'],
    'Deferido'    => ['Arquivado'],
    'Indeferido'  => ['Arquivado'],
];
?>
<th>Setor atual</th>
...
<td><?= htmlspecialchars($p['setor_atual']) ?></td>
<td>
  <a href="protocolo_form.php?id=<?= $p['id'] ?>">Editar</a>
  <?php foreach ($transicoesValidas[$p['status']] ?? [] as $proximo): ?>
    &middot;
    <form method="post" action="tramitar.php" style="display:inline;">
      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <input type="hidden" name="novo_status" value="<?= htmlspecialchars($proximo) ?>">
      <button type="submit" onclick="return confirm('Mudar status para <?= htmlspecialchars($proximo) ?>?');"><?= htmlspecialchars($proximo) ?></button>
    </form>
  <?php endforeach; ?>
</td>
```

**Resultado esperado — trecho de `protocolo_form.php`** (só quando `$id` está definido):

```php
<?php if ($id): ?>
  <hr>
  <h2>Histórico</h2>
  <?php
    $stmtHist = $pdo->prepare('SELECT * FROM protocolo_historico WHERE protocolo_id = ? ORDER BY data DESC');
    $stmtHist->execute([$id]);
    $historico = $stmtHist->fetchAll();
  ?>
  <?php if (empty($historico)): ?>
    <p>Nenhuma movimentação registrada.</p>
  <?php else: ?>
    <ul>
      <?php foreach ($historico as $h): ?>
        <li><?= htmlspecialchars($h['status_anterior']) ?> → <?= htmlspecialchars($h['status_novo']) ?> (<?= htmlspecialchars($h['setor']) ?>, <?= htmlspecialchars($h['data']) ?>)</li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
<?php endif; ?>
```

## Testando ao vivo

1. Abrir `index.php` — cada protocolo "Aberto" deve mostrar um botão "Em Análise".
2. Clicar nele → status muda, e a listagem já reflete o novo botão disponível ("Deferido"/"Indeferido").
3. Deferir (ou indeferir) → confirma que o botão "Arquivado" aparece.
4. Arquivar → nenhum botão de transição sobra na linha.
5. Tentar forçar uma transição inválida direto pela URL (ex.: `tramitar.php` com `novo_status=Arquivado` num protocolo "Aberto") → confirma que `tramitar.php` recusa e nada muda.
6. Abrir `protocolo_form.php?id=...` de um protocolo já tramitado → confirmar que o histórico aparece completo, na ordem certa.

## Pontos para comentar com a turma

- Os três prompts vieram de três specs, não do nada — é o ciclo fechado que a aula formalizou hoje: requisito → spec → prompt → código → verificação.
- A validação de transições em `tramitar.php` é o RNF "só usuários do setor responsável" e o RF "respeitar as transições permitidas" virando código, lado a lado — vale apontar isso explicitamente.
- Assim como no Desafio (mock), o teste do passo 5 (tentar burlar via URL) é o critério de aceitação "só é possível mudar para uma transição permitida" sendo verificado de verdade, não só "parecendo certo" na tela.
