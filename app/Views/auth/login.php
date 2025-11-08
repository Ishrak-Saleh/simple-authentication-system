<?php
$title = 'Login | AuthBoard';
ob_start();
?>
<div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white dark:bg-dark-200 rounded-2xl shadow-xl p-8 border dark:border-dark-100">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome back</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">Sign in to your account</p>
            </div>
            
            <form method="POST" action="/login" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-dark-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-dark-300 dark:text-white transition-colors"
                           placeholder="Enter your email">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-dark-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-dark-300 dark:text-white transition-colors"
                               placeholder="Enter your password"
                               id="password">
                        <button type="button" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:text-gray-300 dark:hover:text-white" 
                                onclick="togglePassword('password', this)">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <button type="submit" 
                        class="w-full bg-primary text-white py-3 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors font-medium">
                    Sign in
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-gray-600 dark:text-gray-400">
                    Don't have an account? 
                    <a href="/register" class="text-primary hover:text-blue-600 font-medium transition-colors">Sign up</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, button) {
    const passwordInput = document.getElementById(inputId);
    const icon = button.querySelector('svg');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L7.59 7.59m0 0a9.953 9.953 0 01-2.029-1.563M7.59 7.59L4.5 4.5m0 0L2.229 2.23M4.5 4.5l2.09 2.09"/>';
    } else {
        passwordInput.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';