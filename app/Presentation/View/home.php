<?php

session_start();

if (isset($_SESSION['email'])) {
    header('Location: /finances');
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MinhaDespesa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon"
        href="https://cdn.iconscout.com/icon/free/png-256/free-cash-icon-download-in-svg-png-gif-file-formats--money-currency-dollar-payment-bank-investing-and-finance-pack-business-icons-1746112.png"
        type="image/x-icon">

</head>

<body class="bg-gray-100 text-gray-800 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-indigo-600">
                <!-- Placeholder para Logo -->
                <img src="/img/minha-despesa-logo-1.png" alt="Logo" class="h-10 inline-block mr-2">
                MinhaDespesa
            </a>
            <div class="space-x-4">
                <a href="#features" class="text-gray-600 hover:text-indigo-600">Funcionalidades</a>
                <a href="#about" class="text-gray-600 hover:text-indigo-600">Sobre</a>
                <a href="#contact" class="text-gray-600 hover:text-indigo-600">Contato</a>
                <a href="/login" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Começar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-indigo-600 text-white">
        <div class="container mx-auto px-6 py-20 text-center">
            <h1 class="text-5xl font-bold mb-4">Gerencie Suas Finanças com Facilidade</h1>
            <p class="text-xl mb-8">Adicione despesas, receitas e planeje seus gastos futuros de forma simples e objetiva.</p>
            <a href="#" class="bg-white text-indigo-600 font-bold px-8 py-3 rounded-md hover:bg-gray-200 text-lg">Experimente Agora</a>
            <div class="mt-12">
                <!-- Placeholder para Demonstração Principal -->
                <div class="bg-gray-300 h-80 w-full max-w-3xl mx-auto rounded-lg shadow-xl flex items-center justify-center">
                    <span class="text-gray-500 text-xl">Placeholder para Demonstração do App (e.g., GIF ou Imagem)</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Funcionalidades Principais</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg text-center">
                    <!-- Placeholder para Ícone da Funcionalidade -->
                    <div class="bg-indigo-100 text-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Registre Despesas e Receitas</h3>
                    <p class="text-gray-600">Adicione facilmente suas despesas e receitas, informando valor, categoria, data e descrição para cada transação.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg text-center">
                    <!-- Placeholder para Ícone da Funcionalidade -->
                    <div class="bg-indigo-100 text-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-3.75h.008v.008H12v-.008ZM12 15h.008v.008H12v-.008ZM12 12h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75v-.008ZM9.75 12h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5v-.008ZM7.5 12h.008v.008H7.5v-.008ZM4.5 15h.008v.008H4.5v-.008ZM4.5 12h.008v.008H4.5v-.008ZM17.25 15h.008v.008H17.25v-.008ZM17.25 12h.008v.008H17.25v-.008ZM19.5 15h.008v.008H19.5v-.008ZM19.5 12h.008v.008H19.5v-.008Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Planeje Despesas Futuras</h3>
                    <p class="text-gray-600">Antecipe seus gastos registrando despesas futuras, ajudando você a se preparar financeiramente.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-gray-50 p-8 rounded-lg shadow-lg text-center">
                    <!-- Placeholder para Ícone da Funcionalidade -->
                    <div class="bg-indigo-100 text-indigo-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Estatísticas Futuras</h3>
                    <p class="text-gray-600">Em breve: Acompanhe sua média de gastos mensais e outras estatísticas para um melhor controle financeiro.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Sobre o Projeto</h2>
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-lg text-gray-700 mb-4">
                    Nosso site de despesas foi criado para ser uma ferramenta objetiva e direta ao ponto, ajudando você a ter uma visão clara de suas finanças.
                    Acreditamos que o controle financeiro não precisa ser complicado.
                </p>
                <p class="text-lg text-gray-700">
                    Com funcionalidades essenciais e uma interface intuitiva, nosso objetivo é facilitar o seu dia a dia financeiro e, no futuro, fornecer insights valiosos através de estatísticas detalhadas.
                </p>
                <!-- Placeholder para Imagem Sobre o Projeto/Equipe -->
                <div class="mt-10 bg-gray-300 h-64 w-full max-w-xl mx-auto rounded-lg shadow-lg flex items-center justify-center">
                    <span class="text-gray-500 text-xl">Placeholder para Imagem (e.g., Time ou Conceito do App)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-indigo-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-6">Pronto para Organizar Suas Finanças?</h2>
            <p class="text-xl mb-8">Comece hoje mesmo a controlar seus gastos e receitas de forma eficiente.</p>
            <a href="/register" class="bg-white text-indigo-600 font-bold px-10 py-4 rounded-md hover:bg-gray-200 text-lg">Criar Minha Conta Gratuitamente</a>
        </div>
    </section>

    <!-- Contact Section (Simples) -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Entre em Contato</h2>
            <p class="text-lg text-gray-700 mb-8">Tem alguma dúvida ou sugestão? Adoraríamos ouvir você!</p>
            <a href="mailto:seuemail@example.com" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 text-lg">Enviar Email</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-10">
        <div class="container mx-auto px-6 text-center">
            <p>&copy; <span id="currentYear"></span> MinhaDespesa. Todos os direitos reservados.</p>
            <p class="mt-2">
                <a href="#" class="text-indigo-400 hover:text-indigo-300">Política de Privacidade</a> |
                <a href="#" class="text-indigo-400 hover:text-indigo-300">Termos de Serviço</a>
            </p>
            <!-- Placeholder para Redes Sociais -->
            <div class="mt-4">
                <a href="https://github.com/DeividSouSan" class="text-gray-400 hover:text-white mx-2">GitHub</a>
                <a href="https://www.tabnews.com.br/DeividSouSan/conteudos/1" class="text-gray-400 hover:text-white mx-2">TabNews</a>
                <a href="https://www.linkedin.com/in/deividsousan/" class="text-gray-400 hover:text-white mx-2">LinkedIn</a>
            </div>
        </div>
    </footer>

    <script>
        // Atualiza o ano no rodapé
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>
