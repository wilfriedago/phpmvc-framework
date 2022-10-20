<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="shortcut icon" href="<?= assetUrl('src/assets/vite.svg') ?>" type="image/x-icon">
    <?= vite('src/main.js') ?>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Whenever the user explicitly chooses light mode
        localStorage.theme = 'light'

        // Whenever the user explicitly chooses dark mode
        localStorage.theme = 'dark'

        // Whenever the user explicitly chooses to respect the OS preference
        localStorage.removeItem('theme')
    </script>
</head>
<body>
    <main class="h-screen w-full dark:bg-slate-900 bg-white grid place-items-center">
    {{content}}
    </main>
</body>
</html>
