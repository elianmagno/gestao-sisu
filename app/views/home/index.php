<!DOCTYPE html>
<html lang="pt-BR" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SISU - Sistema de Seleção Unificada</title>
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
    <style>
        html {
            scrollbar-gutter: stable;
        }
    </style>
</head>

<body class="min-h-full bg-gov-gray flex flex-col">

    <main class="flex-1">

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-gov-blue via-gov-blue-warm to-gov-blue-dark text-white">
            <div class="max-w-6xl mx-auto px-6 py-16 sm:py-24">
                <div class="max-w-2xl">
                    <span class="inline-block bg-white/15 text-sm font-medium px-3 py-1 rounded-full mb-4">Simulação
                        Acadêmica</span>
                    <h2 class="text-3xl sm:text-5xl font-extrabold leading-tight mb-4">
                        Gestão do <span class="text-yellow-300">SISU</span>
                    </h2>
                    <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                        Sistema de gerenciamento de candidatos, cursos, edições e
                        convocações, simulando o processo seletivo do SISU (Sistema de
                        Seleção Unificada) do Ministério da Educação.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="/candidato/index"
                            class="inline-flex items-center gap-2 bg-white text-gov-blue font-semibold px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                            Acessar Sistema
                        </a>
                        <a href="/convocacao/create"
                            class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white font-semibold px-6 py-3 rounded-lg transition-colors border border-white/30">
                            Gerar Convocação
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features grid -->
        <section class="max-w-6xl mx-auto px-6 py-16">
            <h3 class="text-center text-2xl font-bold text-gov-blue-dark mb-2">Módulos do Sistema</h3>
            <p class="text-center text-gray-500 mb-10">Gerencie todo o processo seletivo em um só lugar</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Candidatos -->
                <a href="/candidato/index"
                    class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-gov-blue/30 transition-all">
                    <div
                        class="bg-blue-50 text-gov-blue w-12 h-12 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gov-blue group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gov-blue-dark mb-1">Candidatos</h4>
                    <p class="text-sm text-gray-500">Cadastre e gerencie os candidatos inscritos no processo seletivo.
                    </p>
                </a>

                <!-- Cursos -->
                <a href="/curso/index"
                    class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-gov-blue/30 transition-all">
                    <div
                        class="bg-blue-50 text-gov-blue w-12 h-12 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gov-blue group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gov-blue-dark mb-1">Cursos</h4>
                    <p class="text-sm text-gray-500">Gerencie os cursos disponíveis para inscrição no SISU.</p>
                </a>

                <!-- Edições -->
                <a href="/edicao/index"
                    class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-gov-blue/30 transition-all">
                    <div
                        class="bg-blue-50 text-gov-blue w-12 h-12 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gov-blue group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gov-blue-dark mb-1">Edições</h4>
                    <p class="text-sm text-gray-500">Configure edições com distribuição de vagas por modalidade.</p>
                </a>

                <!-- Convocação -->
                <a href="/convocacao/create"
                    class="group bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md hover:border-gov-blue/30 transition-all">
                    <div
                        class="bg-green-50 text-gov-green w-12 h-12 rounded-lg flex items-center justify-center mb-4 group-hover:bg-gov-green group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gov-blue-dark mb-1">Convocação</h4>
                    <p class="text-sm text-gray-500">Gere listas de convocação com fator multiplicador de vagas.</p>
                </a>

            </div>
        </section>

        <?php include __DIR__ . '/../partials/footer.php'; ?>