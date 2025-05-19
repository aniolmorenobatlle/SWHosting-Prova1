<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prova 1 SWHosting</title>

    @vite('resources/css/app.css')
</head>

<body class="flex flex-col gap-20 min-h-screen items-center bg-gray-100 p-4">

    <h1
        class="text-4xl sm:text-6xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 drop-shadow-lg">
        Cercador de dominis
    </h1>

    <div class="flex flex-col-reverse md:flex-row gap-6 w-full max-w-5xl mx-auto justify-center items-start">
        <div class="flex flex-col w-full md:w-2/3 gap-5">
            <livewire:cercador />
            <livewire:resultats />
        </div>

        <div class="w-full md:w-1/3">
            <livewire:carrito />
        </div>
    </div>

</body>

</html>
