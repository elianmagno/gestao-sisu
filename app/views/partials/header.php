<?php
if (!function_exists('formatCpf')) {
    function formatCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return substr($cpf, 0, 3).'.'.substr($cpf, 3, 3).'.'.substr($cpf, 6, 3).'-'.substr($cpf, 9, 2);
    }
}
if (!function_exists('formatDate')) {
    function formatDate(string $date): string
    {
        return date('d/m/Y', strtotime($date));
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'SISU - Gestão' ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gov: {
                            blue: '#1351B4',
                            'blue-dark': '#071D41',
                            'blue-warm': '#155BCB',
                            green: '#168821',
                            'green-dark': '#0B6413',
                            gray: '#F8F8F8',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="icon" href="/public/images/icon.svg" type="image/svg+xml">
</head>

<body class="min-h-full bg-gov-gray flex flex-col overflow-y-scroll">

    <!-- Barra superior gov.br -->
    <div class="bg-gov-blue-dark">
        <div class="max-w-7xl mx-auto px-4 py-1 flex items-center justify-between">
            <span class="text-green-400 text-xs font-semibold tracking-wider">GOV.BR</span>
            <span class="text-gray-300 text-xs">Sistema de Seleção Unificada</span>
        </div>
    </div>

    <!-- Header principal -->
    <header class="bg-gov-blue shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3">
                    <img src="/public/images/logo.svg" alt="SISU" class="h-8">
                </a>

                <!-- Botão mobile -->
                <button onclick="document.getElementById('navMenu').classList.toggle('hidden')"
                    class="sm:hidden text-white p-2 rounded hover:bg-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Navegação -->
                <nav id="navMenu" class="hidden sm:flex items-center gap-1">
                    <?php
                    $navItems = [
                        ['label' => 'Candidatos', 'href' => '/candidato/index', 'key' => 'candidato'],
                        ['label' => 'Cursos',     'href' => '/curso/index',     'key' => 'curso'],
                        ['label' => 'Edições',    'href' => '/edicao/index',    'key' => 'edicao'],
                        ['label' => 'Convocação', 'href' => '/convocacao/create','key' => 'convocacao'],
                    ];
foreach ($navItems as $item):
    $isActive = ($activeNav ?? '') === $item['key'];
    ?>
                    <a href="<?= $item['href'] ?>"
                        class="px-4 py-2 rounded-md text-sm font-medium transition-colors
                              <?= $isActive
                  ? 'bg-white/20 text-white'
                  : 'text-blue-100 hover:bg-white/10 hover:text-white' ?>">
                        <?= $item['label'] ?>
                    </a>
                    <?php endforeach; ?>
                </nav>
            </div>


        </div>
    </header>

    <!-- Conteúdo principal -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 py-8">