<?php
// Teste real de N+1 vs GROUP BY, para medir números genuínos antes de citar na Aula 9.
$pdo = new PDO('sqlite::memory:');
$pdo->exec('CREATE TABLE protocolos (id INTEGER PRIMARY KEY, requerente TEXT, status TEXT)');

$requerentes = [];
for ($i = 1; $i <= 80; $i++) {
    $requerentes[] = "Requerente $i";
}

$pdo->beginTransaction();
$stmt = $pdo->prepare('INSERT INTO protocolos (requerente, status) VALUES (?, ?)');
$status_opcoes = ['Aberto', 'Em Análise', 'Deferido', 'Indeferido', 'Arquivado'];
mt_srand(42);
for ($i = 0; $i < 2000; $i++) {
    $r = $requerentes[array_rand($requerentes)];
    $s = $status_opcoes[array_rand($status_opcoes)];
    $stmt->execute([$r, $s]);
}
$pdo->commit();

// --- Versão N+1 (ingênua) ---
$queries_n1 = 0;
$t0 = hrtime(true);
$lista_requerentes = $pdo->query('SELECT DISTINCT requerente FROM protocolos')->fetchAll(PDO::FETCH_COLUMN);
$queries_n1++;
$contagem_n1 = [];
foreach ($lista_requerentes as $req) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM protocolos WHERE requerente = ?');
    $stmt->execute([$req]);
    $contagem_n1[$req] = $stmt->fetchColumn();
    $queries_n1++;
}
$t1 = hrtime(true);
$tempo_n1_ms = ($t1 - $t0) / 1e6;

// --- Versão otimizada (uma consulta, GROUP BY) ---
$queries_opt = 0;
$t2 = hrtime(true);
$stmt = $pdo->query('SELECT requerente, COUNT(*) as total FROM protocolos GROUP BY requerente');
$queries_opt++;
$contagem_opt = [];
foreach ($stmt as $row) {
    $contagem_opt[$row['requerente']] = $row['total'];
}
$t3 = hrtime(true);
$tempo_opt_ms = ($t3 - $t2) / 1e6;

echo "Total de protocolos: 2000, requerentes distintos: " . count($lista_requerentes) . "\n";
echo "--- N+1 (ingênua) ---\n";
echo "Consultas ao banco: $queries_n1\n";
echo "Tempo: " . number_format($tempo_n1_ms, 3) . " ms\n";
echo "--- Otimizada (GROUP BY) ---\n";
echo "Consultas ao banco: $queries_opt\n";
echo "Tempo: " . number_format($tempo_opt_ms, 3) . " ms\n";
echo "--- Comparação ---\n";
echo "Reducao de consultas: " . $queries_n1 . " -> " . $queries_opt . " (" . round($queries_n1/$queries_opt) . "x menos)\n";
echo "Speedup: " . round($tempo_n1_ms / $tempo_opt_ms, 1) . "x mais rápido\n";

// Conferir que os resultados batem (mesma contagem)
ksort($contagem_n1); ksort($contagem_opt);
echo "Resultados idênticos: " . (($contagem_n1 == $contagem_opt) ? "SIM" : "NAO") . "\n";
