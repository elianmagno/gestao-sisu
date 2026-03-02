<?php
$pageTitle = isset($course->id) ? 'Editar Curso - SISU' : 'Novo Curso - SISU';
$activeNav = 'curso';
$path = isset($course->id) ? 'update?id=' . $course->id : 'store';
?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/curso/index" class="text-gov-blue hover:underline">Cursos</a> <span class="mx-2">/</span>
    <span
        class="text-gov-blue font-medium"><?= isset($course->id) ? 'Editar' : 'Novo' ?></span>
</nav>

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gov-blue px-6 py-4">
            <h1 class="text-xl font-bold text-white">
                <?= isset($course->id) ? 'Editar Curso' : 'Novo Curso' ?>
            </h1>
            <p class="text-blue-200 text-sm mt-1">Preencha o nome do curso</p>
        </div>

        <div class="p-6">
            <?php include __DIR__ . '/../partials/alert.php'; ?>

            <form action="/curso/<?= $path ?>" method="post"
                class="space-y-4">

                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome do curso</label>
                    <input
                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-gov-blue focus:border-gov-blue outline-none transition"
                        id="nome" name="nome" type="text" required placeholder="Ex: Ciência da Computação"
                        value="<?= htmlspecialchars($course->nome ?? '') ?>" />
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="/curso/index"
                        class="flex-1 text-center px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="flex-1 px-5 py-2.5 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors shadow-sm">
                        <?= isset($course->id) ? 'Atualizar' : 'Cadastrar' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>