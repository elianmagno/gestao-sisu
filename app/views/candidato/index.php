<?php $pageTitle = 'Candidatos - SISU';
$activeNav = 'candidato'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
    <span>Início</span> <span class="mx-2">/</span>
    <span class="text-gov-blue font-medium">Candidatos</span>
</nav>

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gov-blue-dark">Candidatos</h1>
        <p class="text-gray-500 text-sm mt-1">Gerencie os candidatos inscritos no sistema</p>
    </div>
    <a href="/candidato/create"
        class="inline-flex items-center gap-2 bg-gov-green hover:bg-gov-green-dark text-white font-medium px-5 py-2.5 rounded-lg transition-colors shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Novo Candidato
    </a>
</div>

<?php include __DIR__ . '/../partials/alert.php'; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gov-blue text-white text-left">
                    <th class="px-4 py-3 font-medium">Nome</th>
                    <th class="px-4 py-3 font-medium">CPF</th>
                    <th class="px-4 py-3 font-medium">Nascimento</th>
                    <th class="px-4 py-3 font-medium">Categoria</th>
                    <th class="px-4 py-3 font-medium">Curso</th>
                    <th class="px-4 py-3 font-medium">Edição</th>
                    <th class="px-4 py-3 font-medium">Nota</th>
                    <th class="px-4 py-3 font-medium text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($candidates as $candidate): ?>
                <tr class="hover:bg-blue-50/50 transition-colors">
                    <td class="px-4 py-3 font-medium text-gray-900">
                        <?= htmlspecialchars($candidate->nome) ?>
                    </td>
                    <td class="px-4 py-3 text-gray-600 font-mono text-xs">
                        <?= formatCpf($candidate->cpf) ?>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        <?= formatDate($candidate->data_nascimento) ?>
                    </td>
                    <td class="px-4 py-3">
                        <span
                            class="inline-block bg-blue-100 text-gov-blue text-xs font-medium px-2.5 py-1 rounded-full whitespace-nowrap">
                            <?= htmlspecialchars($candidate->categoria) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        <?= htmlspecialchars($candidate->cursos->nome) ?>
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        <?= htmlspecialchars($candidate->edicoes->nome) ?>
                    </td>
                    <td class="px-4 py-3 font-semibold text-gray-800">
                        <?= $candidate->nota ?>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="/candidato/show?id=<?= $candidate->id ?>"
                                class="p-1.5 rounded-md text-gray-400 hover:text-gov-blue hover:bg-blue-50 transition-colors"
                                title="Visualizar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="/candidato/edit?id=<?= $candidate->id ?>"
                                class="p-1.5 rounded-md text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 transition-colors"
                                title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a href="/candidato/destroy?id=<?= $candidate->id ?>"
                                class="p-1.5 rounded-md text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                title="Excluir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>