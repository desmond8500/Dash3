<!DOCTYPE html>
<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{ $slot ?? '' }}

    <div id="vue-app"></div>

</body>

</html>
