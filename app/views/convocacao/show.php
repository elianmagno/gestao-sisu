<?php $pageTitle = 'Lista de Convocação - SISU';
$activeNav = 'convocacao'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/convocacao/create" class="text-gov-blue hover:underline">Convocação</a> <span class="mx-2">/</span>
    <span class="text-gov-blue font-medium">Resultado</span>
</nav>

<!-- Cabeçalho do resultado -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-gov-blue px-6 py-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-white">Lista de Convocação</h1>
                <p class="text-blue-200 text-sm mt-1">Resultado gerado com fator multiplicador
                    <?= $multiplicationFactor ?>
                </p>
            </div>
            <a href="/convocacao/create"
                class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white font-medium px-4 py-2 rounded-lg transition-colors text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Nova Consulta
            </a>
        </div>
    </div>
    <div class="px-6 py-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Curso</dt>
            <dd class="mt-1 text-sm text-gray-900 font-semibold">
                <?= htmlspecialchars($selectedCourse->nome) ?>
            </dd>
        </div>
        <div>
            <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Edição</dt>
            <dd class="mt-1 text-sm text-gray-900 font-semibold">
                <?= htmlspecialchars($selectedEdition->nome) ?>
            </dd>
        </div>
    </div>
</div>

<!-- Resultado por categoria -->
<?php foreach ($calledCandidates as $categoryName => $candidates): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
    <div class="bg-gov-blue-dark px-6 py-3 flex items-center justify-between">
        <h2 class="text-base font-semibold text-white">
            <?= htmlspecialchars($categoryName) ?>
        </h2>
        <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">
            <?= $candidates->count() ?> candidato(s)
        </span>
    </div>

    <?php if ($candidates->isEmpty()): ?>
    <div class="text-center py-8 text-gray-400">
        <p>Nenhum candidato inscrito nesta modalidade.</p>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-left">
                    <th class="px-4 py-3 font-medium w-12 text-center">#</th>
                    <th class="px-4 py-3 font-medium">Nome</th>
                    <th class="px-4 py-3 font-medium">CPF</th>
                    <th class="px-4 py-3 font-medium text-center">Nota</th>
                    <th class="px-4 py-3 font-medium text-center">Situação</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $position = 1; ?>
                <?php foreach ($candidates as $candidate): ?>
                <tr
                    class="<?= $candidate->situacao === 'Classificado/Aprovado' ? 'bg-green-50/50' : 'bg-red-50/30' ?> hover:bg-blue-50/50 transition-colors">
                    <td class="px-4 py-3 text-center text-gray-400 font-mono text-xs">
                        <?= $position++ ?>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-900">
                        <?= htmlspecialchars($candidate->nome) ?>
                    </td>
                    <td class="px-4 py-3 text-gray-600 font-mono text-xs">
                        <?= formatCpf($candidate->cpf) ?>
                    </td>
                    <td class="px-4 py-3 text-center font-semibold text-gray-800">
                        <?= $candidate->nota ?>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <?php if ($candidate->situacao === 'Classificado/Aprovado'): ?>
                        <span
                            class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Classificado
                        </span>
                        <?php else: ?>
                        <span
                            class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Não Classificado
                        </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<?php endforeach; ?>

<?php include __DIR__ . '/../partials/footer.php'; ?>