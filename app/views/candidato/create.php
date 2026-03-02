<?php
$pageTitle = isset($candidate->id) ? 'Editar Candidato - SISU' : 'Novo Candidato - SISU';
$activeNav = 'candidato';
$path = isset($candidate->id) ? 'update?id=' . $candidate->id : 'store';
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/candidato/index" class="text-gov-blue hover:underline">Candidatos</a> <span class="mx-2">/</span>
    <span
        class="text-gov-blue font-medium"><?= isset($candidate->id) ? 'Editar' : 'Novo' ?></span>
</nav>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <!-- Card header -->
        <div class="bg-gov-blue px-6 py-4">
            <h1 class="text-xl font-bold text-white">
                <?= isset($candidate->id) ? 'Editar Candidato' : 'Novo Candidato' ?>
            </h1>
            <p class="text-blue-200 text-sm mt-1">Preencha os dados do candidato</p>
        </div>

        <!-- Card body -->
        <div class="p-6">
            <?php include __DIR__ . '/../partials/alert.php'; ?>

            <form action="/candidato/<?= $path ?>" method="post"
                class="space-y-4">

                <!-- Nome -->
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome completo</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="nome" name="nome" type="text" required placeholder="Digite o nome completo"
                        value="<?= htmlspecialchars($candidate->nome ?? '') ?>" />
                </div>

                <!-- CPF -->
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 mb-1">CPF</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-mono focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="cpf" name="cpf" type="text" required placeholder="000.000.000-00" maxlength="14"
                        value="<?= htmlspecialchars(isset($candidate->cpf) && $candidate->cpf ? formatCpf($candidate->cpf) : '') ?>" />
                </div>

                <!-- Data de Nascimento -->
                <div>
                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700 mb-1">Data de
                        nascimento</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="data_nascimento" name="data_nascimento" type="date" required
                        value="<?= htmlspecialchars($candidate->data_nascimento ?? '') ?>" />
                </div>

                <!-- Categoria -->
                <div>
                    <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Modalidade de
                        concorrência</label>
                    <select
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition bg-white"
                        id="categoria" name="categoria" required>
                        <option value="" disabled <?= empty($candidate->categoria) ? 'selected' : '' ?>>Selecione
                            uma opção</option>
                        <?php
                        $categories = ['Ampla Concorrência','PPI - Pública - Baixa Renda','Pública - Baixa Renda','PPI - Pública','Pública','Deficientes'];
foreach ($categories as $cat):
    ?>
                        <option value="<?= $cat ?>" <?= ($candidate->categoria ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Curso -->
                <div>
                    <label for="curso_id" class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                    <select
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition bg-white"
                        id="curso_id" name="curso_id" required>
                        <option value="" disabled <?= empty($candidate->curso_id) ? 'selected' : '' ?>>Selecione
                            um curso</option>
                        <?php foreach ($courses as $course): ?>
                        <option value="<?= $course->id ?>" <?= ($candidate->curso_id ?? '') == $course->id ? 'selected' : '' ?>><?= htmlspecialchars($course->nome) ?>
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
                        <option value="" disabled <?= empty($candidate->edicao_id) ? 'selected' : '' ?>>Selecione
                            uma edição</option>
                        <?php foreach ($editions as $edition): ?>
                        <option value="<?= $edition->id ?>" <?= ($candidate->edicao_id ?? '') == $edition->id ? 'selected' : '' ?>><?= htmlspecialchars($edition->nome) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nota -->
                <div>
                    <label for="nota" class="block text-sm font-medium text-gray-700 mb-1">Nota (0 – 1000)</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="nota" name="nota" type="number" min="0" max="1000" step="0.01" required placeholder="0.00"
                        value="<?= htmlspecialchars($candidate->nota ?? '') ?>" />
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-4">
                    <a href="/candidato/index"
                        class="flex-1 text-center px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 px-5 py-2.5 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors shadow-sm">
                        <?= isset($candidate->id) ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    const cpfInput = document.getElementById('cpf');
    cpfInput.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '').substring(0, 11);
        if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        e.target.value = v;
    });
    cpfInput.closest('form').addEventListener('submit', function() {
        cpfInput.value = cpfInput.value.replace(/\D/g, '');
    });
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>