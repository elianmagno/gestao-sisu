<?php $pageTitle = 'Detalhes do Curso - SISU';
$activeNav = 'curso'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <a href="/curso/index" class="text-gov-blue hover:underline">Cursos</a> <span class="mx-2">/</span>
    <span class="text-gov-blue font-medium">Detalhes</span>
</nav>

<?php include __DIR__ . '/../partials/alert.php'; ?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gov-blue px-6 py-4">
            <h1 class="text-xl font-bold text-white">
                <?= htmlspecialchars($course->nome) ?>
            </h1>
            <p class="text-blue-200 text-sm mt-1">Detalhes do curso</p>
        </div>

        <div class="p-6">
            <dl class="space-y-4">
                <div>
                    <dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Nome do Curso</dt>
                    <dd class="mt-1 text-sm text-gray-900 font-medium">
                        <?= htmlspecialchars($course->nome) ?>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3">
            <a href="/curso/index"
                class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-100 transition-colors">
                Voltar
            </a>
            <a href="/curso/edit?id=<?= $course->id ?>"
                class="px-5 py-2 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors">
                Editar
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>