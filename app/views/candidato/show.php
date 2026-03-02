<?php $pageTitle = 'Detalhes do Candidato - SISU';
$activeNav = 'candidato'; ?>
<?php include __DIR__ . '/../partials/header.php'; ?>

<nav class="text-sm text-gray-500 mb-6">
	<span>Início</span> <span class="mx-2">/</span>
	<a href="/candidato/index" class="text-gov-blue hover:underline">Candidatos</a> <span class="mx-2">/</span>
	<span class="text-gov-blue font-medium">Detalhes</span>
</nav>

<?php include __DIR__ . '/../partials/alert.php'; ?>

<div class="max-w-3xl mx-auto">
	<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
		<!-- Card header -->
		<div class="bg-gov-blue px-6 py-4 flex items-center justify-between">
			<div>
				<h1 class="text-xl font-bold text-white">
					<?= htmlspecialchars($candidate->nome) ?>
				</h1>
				<p class="text-blue-200 text-sm mt-1">Detalhes do candidato</p>
			</div>
			<span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">
				Nota: <?= $candidate->nota ?>
			</span>
		</div>

		<!-- Card body -->
		<div class="p-6">
			<dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-5">
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Nome</dt>
					<dd class="mt-1 text-sm text-gray-900 font-medium">
						<?= htmlspecialchars($candidate->nome) ?>
					</dd>
				</div>
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">CPF</dt>
					<dd class="mt-1 text-sm text-gray-900 font-mono">
						<?= formatCpf($candidate->cpf) ?>
					</dd>
				</div>
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Data de Nascimento</dt>
					<dd class="mt-1 text-sm text-gray-900">
						<?= formatDate($candidate->data_nascimento) ?>
					</dd>
				</div>
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Modalidade</dt>
					<dd class="mt-1">
						<span
							class="inline-block bg-blue-100 text-gov-blue text-xs font-medium px-2.5 py-1 rounded-full">
							<?= htmlspecialchars($candidate->categoria) ?>
						</span>
					</dd>
				</div>
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Curso</dt>
					<dd class="mt-1 text-sm text-gray-900">
						<?= htmlspecialchars($candidate->cursos->nome) ?>
					</dd>
				</div>
				<div>
					<dt class="text-xs font-medium text-gray-400 uppercase tracking-wider">Edição</dt>
					<dd class="mt-1 text-sm text-gray-900">
						<?= htmlspecialchars($candidate->edicoes->nome) ?>
					</dd>
				</div>
			</dl>
		</div>

		<!-- Card footer -->
		<div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3">
			<a href="/candidato/index"
				class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium text-sm hover:bg-gray-100 transition-colors">
				Voltar
			</a>
			<a href="/candidato/edit?id=<?= $candidate->id ?>"
				class="px-5 py-2 rounded-lg bg-gov-blue hover:bg-gov-blue-warm text-white font-medium text-sm transition-colors">
				Editar
			</a>
		</div>
	</div>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>