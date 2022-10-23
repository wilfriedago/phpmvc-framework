<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Authentication Layout</title>
        <link rel="shortcut icon" href="<?= assetUrl('src/assets/vite.svg') ?>" type="image/x-icon">
        <?= vite('src/main.js') ?>
        <script type="text/javascript">
            (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches))
                ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark');
        </script>
    </head>
    <body>
        <main class="h-screen w-full dark:bg-slate-500 bg-white grid place-items-center">
            {{content}}
        </main>
    </body>
</html>
