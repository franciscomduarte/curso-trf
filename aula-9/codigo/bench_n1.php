<?php
// Teste real de N+1 vs GROUP BY, para medir números genuínos antes de citar na Aula 9.
$pdo = new PDO('sqlite::memory:');
$pdo->exec('CREATE TABLE equipamentos (id INTEGER PRIMARY KEY, nome TEXT)');
$pdo->exec('CREATE TABLE emprestimos (id INTEGER PRIMARY KEY, equipamento_id INTEGER, servidor TEXT)');

$equipamento_ids = [];
$pdo->beginTransaction();
$stmt = $pdo->prepare('INSERT INTO equipamentos (nome) VALUES (?)');
for ($i = 1; $i <= 30; $i++) {
    $stmt->execute(["Notebook Patrimônio $i"]);
    $equipamento_ids[] = $pdo->lastInsertId();
}
$pdo->commit();

$pdo->beginTransaction();
$stmt = $pdo->prepare('INSERT INTO emprestimos (equipamento_id, servidor) VALUES (?, ?)');
mt_srand(42);
for ($i = 0; $i < 2000; $i++) {
    $eq = $equipamento_ids[array_rand($equipamento_ids)];
    $stmt->execute([$eq, "Servidor " . mt_rand(1, 200)]);
}
$pdo->commit();

// --- Versão N+1 (ingênua) ---
$queries_n1 = 0;
$t0 = hrtime(true);
$lista_equipamentos = $pdo->query('SELECT id, nome FROM equipamentos ORDER BY nome')->fetchAll();
$queries_n1++;
$contagem_n1 = [];
foreach ($lista_equipamentos as $equipamento) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM emprestimos WHERE equipamento_id = ?');
    $stmt->execute([$equipamento['id']]);
    $contagem_n1[$equipamento['nome']] = $stmt->fetchColumn();
    $queries_n1++;
}
$t1 = hrtime(true);
$tempo_n1_ms = ($t1 - $t0) / 1e6;

// --- Versão otimizada (uma consulta, GROUP BY) ---
$queries_opt = 0;
$t2 = hrtime(true);
$stmt = $pdo->query('SELECT equipamentos.nome, COUNT(emprestimos.id) as total FROM equipamentos LEFT JOIN emprestimos ON emprestimos.equipamento_id = equipamentos.id GROUP BY equipamentos.id, equipamentos.nome');
$queries_opt++;
$contagem_opt = [];
foreach ($stmt as $row) {
    $contagem_opt[$row['nome']] = $row['total'];
}
$t3 = hrtime(true);
$tempo_opt_ms = ($t3 - $t2) / 1e6;

echo "Total de empréstimos: 2000, equipamentos distintos: " . count($lista_equipamentos) . "\n";
echo "--- N+1 (ingênua) ---\n";
echo "Consultas ao banco: $queries_n1\n";
echo "Tempo: " . number_format($tempo_n1_ms, 3) . " ms\n";
echo "--- Otimizada (LEFT JOIN + GROUP BY) ---\n";
echo "Consultas ao banco: $queries_opt\n";
echo "Tempo: " . number_format($tempo_opt_ms, 3) . " ms\n";
echo "--- Comparação ---\n";
echo "Reducao de consultas: " . $queries_n1 . " -> " . $queries_opt . " (" . round($queries_n1/$queries_opt) . "x menos)\n";
echo "Speedup: " . round($tempo_n1_ms / $tempo_opt_ms, 1) . "x mais rápido\n";

// Conferir que os resultados batem (mesma contagem)
ksort($contagem_n1); ksort($contagem_opt);
echo "Resultados idênticos: " . (($contagem_n1 == $contagem_opt) ? "SIM" : "NAO") . "\n";
