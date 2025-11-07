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
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 dark:border-dark-100 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-dark-300 dark:text-white transition-colors"
                           placeholder="Enter your password">
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
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';