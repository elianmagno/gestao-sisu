<?php $pageTitle = 'Detalhes da Edição - SISU';
$activeNav = 'edicao'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/edicao/index" class="text-gov-blue hover:underline">Edições</a> <span class="mx-2">/</span>
    <span class="text-gov-blue font-medium">Detalhes</span>
</nav>

<?php include __DIR__ . '/../partials/alert.php'; ?>

<?php
$categoryLabels = [
    'vagas_ac'          => 'Ampla Concorrência',
    'vagas_ppi_br'      => 'PPI - Pública - BR',
    'vagas_publica_br'  => 'Pública - BR',
    'vagas_ppi_publica' => 'PPI - Pública',
    'vagas_publica'     => 'Pública',
    'vagas_deficientes' => 'Deficientes',
];
?>

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gov-blue px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-white">
                    <?= htmlspecialchars($edition->nome) ?>
                </h1>
                <p class="text-blue-200 text-sm mt-1">Detalhes da edição e distribuição de vagas</p>
            </div>

        </div>

        <!-- Tabela de vagas -->
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gov-blue-dark mb-4">Vagas por Curso</h2>

            <?php if ($edition->cursos->isEmpty()): ?>
            <div class="text-center py-8 text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p>Nenhum curso vinculado a esta edição.</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-left">
                            <th class="px-4 py-3 font-medium sticky left-0 bg-gray-50 min-w-[160px]">Curso</th>
                            <?php foreach ($categoryLabels as $label): ?>
                            <th class="px-3 py-3 font-medium text-center text-xs whitespace-nowrap">
                                <?= $label ?>
                            </th>
                            <?php endforeach; ?>
                            <th
                                class="px-3 py-3 font-medium text-center text-xs bg-gov-blue-dark text-white rounded-tr-lg">
                                Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($edition->cursos as $course): ?>
                        <tr class="hover:bg-blue-50/30">
                            <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white">
                                <?= htmlspecialchars($course->nome) ?>
                            </td>
                            <?php
                            $total = 0;
                            foreach ($categoryLabels as $col => $label):
                                $val = $course->pivot->$col ?? 0;
                                $total += $val;
                                ?>
                            <td
                                class="px-3 py-3 text-center <?= $val > 0 ? 'text-gray-900 font-semibold' : 'text-gray-300' ?>">
                                <?= $val ?>
                            </td>
                            <?php endforeach; ?>
                            <td class="px-3 py-3 text-center font-bold text-gov-blue bg-blue-50">
                                <?= $total ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Card footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3">
            <a href="/edicao/index"
                class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-100 transition-colors">
                Voltar
            </a>
            <a href="/edicao/edit?id=<?= $edition->id ?>"
                class="px-5 py-2 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors">
                Editar
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>