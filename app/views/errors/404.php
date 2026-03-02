<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - SISU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gov-blue':      '#1351B4',
                        'gov-blue-dark': '#071D41',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Top bar -->
    <div class="bg-gov-blue-dark text-white text-xs py-1 px-4 text-right">
        <span>Governo Federal</span>
    </div>

    <div class="flex-1 flex items-center justify-center p-6">
        <div class="text-center max-w-md">
            <div class="mb-6">
                <span class="inline-block bg-gov-blue/10 text-gov-blue text-7xl font-black px-8 py-4 rounded-2xl">404</span>
            </div>
            <h1 class="text-2xl font-bold text-gov-blue-dark mb-2">Página não encontrada</h1>
            <p class="text-gray-500 mb-8">A página que você está procurando não existe ou foi removida.</p>
            <a href="/candidato/index"
               class="inline-flex items-center gap-2 bg-gov-blue hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Voltar ao início
            </a>
        </div>
    </div>

</body>
</html>
