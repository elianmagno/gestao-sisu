<?php
$pageTitle = isset($edition->id) ? 'Editar Edição - SISU' : 'Nova Edição - SISU';
$activeNav = 'edicao';
$path = isset($edition->id) ? 'update?id=' . $edition->id : 'store';
$categoryLabels = [
    'vagas_ac'          => 'Ampla Concorrência',
    'vagas_ppi_br'      => 'PPI - Pública - BR',
    'vagas_publica_br'  => 'Pública - BR',
    'vagas_ppi_publica' => 'PPI - Pública',
    'vagas_publica'     => 'Pública',
    'vagas_deficientes' => 'Deficientes',
];
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/edicao/index" class="text-gov-blue hover:underline">Edições</a> <span class="mx-2">/</span>
    <span
        class="text-gov-blue font-medium"><?= isset($edition->id) ? 'Editar' : 'Nova' ?></span>
</nav>

<div class="max-w-5xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gov-blue px-6 py-4">
            <h1 class="text-xl font-bold text-white">
                <?= isset($edition->id) ? 'Editar Edição' : 'Nova Edição' ?>
            </h1>
            <p class="text-blue-200 text-sm mt-1">Configure os dados da edição e a distribuição de vagas por curso</p>
        </div>

        <div class="p-6">
            <?php include __DIR__ . '/../partials/alert.php'; ?>

            <form action="/edicao/<?= $path ?>" method="post"
                class="space-y-6">

                <!-- Nome -->
                <div class="max-w-md">
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome da edição</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="nome" name="nome" type="text" required placeholder="Ex: SISU 2025.1"
                        value="<?= htmlspecialchars($edition->nome ?? '') ?>" />
                </div>

                <!-- Tabela de Vagas -->
                <div>
                    <h2 class="text-lg font-semibold text-gov-blue-dark mb-3">Distribuição de Vagas por Curso</h2>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-left">
                                    <th class="px-4 py-3 font-medium sticky left-0 bg-gray-50 min-w-[160px]">Curso</th>
                                    <?php foreach ($categoryLabels as $col => $label): ?>
                                    <th class="px-3 py-3 font-medium text-center text-xs whitespace-nowrap">
                                        <?= $label ?>
                                    </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($courses as $course): ?>
                                <?php
                                    $pivot = null;
                                    if (isset($edition->id)) {
                                        $pivot = $edition->cursos->find($course->id)?->pivot;
                                    } elseif (is_array($edition->cursos) && isset($edition->cursos[$course->id])) {
                                        $pivot = (object) $edition->cursos[$course->id];
                                    }
                                    ?>
                                <tr class="hover:bg-blue-50/30">
                                    <td class="px-4 py-3 font-medium text-gray-900 sticky left-0 bg-white">
                                        <?= htmlspecialchars($course->nome) ?>
                                        <input type="hidden"
                                            name="cursos[<?= $course->id ?>][curso_id]"
                                            value="<?= $course->id ?>">
                                    </td>
                                    <?php foreach ($categoryLabels as $col => $label): ?>
                                    <td class="px-3 py-2 text-center">
                                        <input
                                            class="w-16 text-center rounded border border-gray-300 px-2 py-1.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                                            name="cursos[<?= $course->id ?>][<?= $col ?>]"
                                            type="number" min="0"
                                            value="<?= $pivot->$col ?? 0 ?>" />
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-2">
                    <a href="/edicao/index"
                        class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors shadow-sm">
                        <?= isset($edition->id) ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>