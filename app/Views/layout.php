<?php
// Get theme from session or default to dark
$theme = \app\Core\Session::get('theme') ?? 'dark';
?>
<!DOCTYPE html>
<html lang="en" class="<?= $theme === 'dark' ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'AuthBoard' ?></title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              primary: '#1877f2',
              dark: {
                100: '#3a3b3c',
                200: '#242526', 
                300: '#18191a'
              }
            }
          }
        }
      }
    </script>
    
    <style>
      body {
        font-family: 'Segoe UI', system-ui, sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
      }
      main {
        flex: 1;
        margin-top: 56px;
      }
    </style>
</head>
<body class="bg-gray-100 dark:bg-dark-300 transition-colors duration-200">

    <header class="bg-white dark:bg-dark-200 shadow-sm border-b dark:border-dark-100 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
 
                <div class="flex items-center <?= empty($_SESSION['user']) ? 'mx-auto' : '' ?>">
                    <h1 class="text-2xl font-bold text-primary dark:text-white">AuthBoard</h1>
                </div>

                <!-- Dark Mode Toggle and Navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-100 transition-colors" title="Toggle dark mode">
                        <svg id="sunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <svg id="moonIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                        </svg>
                    </button>
 
                    <?php if (!empty($_SESSION['user'])): ?>
                    <nav class="flex items-center space-x-4">
                        <a href="/dashboard" 
                           class="p-2 rounded-lg transition-colors <?= ($title ?? '') === 'Dashboard | AuthBoard' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-100' ?>"
                           title="Profile">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </a>
                        
                        <a href="/feed" 
                           class="p-2 rounded-lg transition-colors <?= ($title ?? '') === 'Feed | AuthBoard' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-white hover:bg-gray-100 dark:hover:bg-dark-100' ?>"
                           title="Home">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                        
                        <a href="/logout" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors font-medium ml-2">
                            Logout
                        </a>
                    </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 w-full mt-14">
        <?php echo $content; ?>
    </main>

    <footer class="bg-white dark:bg-dark-200 border-t dark:border-dark-100 mt-auto">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 dark:text-gray-400 text-sm">
                <?php
                $pageTitle = $title ?? '';
                $footerTexts = [
                    'Feed | AuthBoard' => 'You\'ve reached the end :)',
                    'Dashboard | AuthBoard' => 'Your personal space',
                    'Login | AuthBoard' => 'Project Authboard',
                    'Register | AuthBoard' => 'Developed by Ishrak Saleh Chowdhury',
                ];
                
                echo $footerTexts[$pageTitle] ?? 'AuthBoard - Connect and share with others';
                ?>
            </p>
        </div>
    </footer>

    <!-- Dark Mode Script -->
    <script>
        // Check for saved theme preference or respect OS preference
        function getTheme() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                return savedTheme;
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        // Apply theme
        function applyTheme(theme) {
            const html = document.documentElement;
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');

            if (theme === 'dark') {
                html.classList.add('dark');
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            } else {
                html.classList.remove('dark');
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
        }

        // Initialize theme
        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = getTheme();
            applyTheme(currentTheme);

            // Toggle theme on button click
            document.getElementById('darkModeToggle').addEventListener('click', () => {
                const html = document.documentElement;
                const newTheme = html.classList.contains('dark') ? 'light' : 'dark';
                
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Listen for system theme changes
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    const newTheme = e.matches ? 'dark' : 'light';
                    applyTheme(newTheme);
                }
            });
        });
    </script>
</body>
</html>