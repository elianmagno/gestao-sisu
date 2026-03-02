<?php $pageTitle = 'Convocação - SISU';
$activeNav = 'convocacao'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <span class="text-gov-blue font-medium">Convocação</span>
</nav>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gov-blue px-6 py-4">
            <h1 class="text-xl font-bold text-white">Gerar Lista de Convocação</h1>
            <p class="text-blue-200 text-sm mt-1">Selecione o curso, edição e fator multiplicador para gerar a lista</p>
        </div>

        <div class="p-6">
            <?php include __DIR__ . '/../partials/alert.php'; ?>

            <form action="/convocacao/store" method="post" class="space-y-4">

                <!-- Curso -->
                <div>
                    <label for="curso_id" class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                    <select
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition bg-white"
                        id="curso_id" name="curso_id" required>
                        <option value="" disabled selected>Selecione um curso</option>
                        <?php foreach ($courses as $course): ?>
                        <option value="<?= $course->id ?>">
                            <?= htmlspecialchars($course->nome) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Edição -->
                <div>
                    <label for="edicao_id" class="block text-sm font-medium text-gray-700 mb-1">Edição</label>
                    <select
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition bg-white"
                        id="edicao_id" name="edicao_id" required>
                        <option value="" disabled selected>Selecione uma edição</option>
                        <?php foreach ($editions as $edition): ?>
                        <option value="<?= $edition->id ?>">
                            <?= htmlspecialchars($edition->nome) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Fator multiplicador -->
                <div>
                    <label for="multiplicationFactor" class="block text-sm font-medium text-gray-700 mb-1">Fator
                        multiplicador</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="multiplicationFactor" name="multiplicationFactor" type="number" min="1" required
                        value="<?= $multiplicationFactor ?? 1 ?>" />
                    <p class="text-xs text-gray-400 mt-1">Multiplica o número de vagas para gerar excedentes</p>
                </div>

                <!-- Botão -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full px-5 py-3 rounded-lg bg-gov-green hover:bg-gov-green-dark text-white font-medium text-sm transition-colors shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Gerar Lista de Convocação
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>