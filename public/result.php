<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>After pay</title>

</head>

<body onclick="returnToApp()">
<style>
    body {
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
        background-color: #2f2020;
    }
    .link-to-app {
        text-decoration: underline;
        letter-spacing: 1px;
        font-size: 24px;
        font-family: 'Graphik', sans-serif;
        font-weight: 400;
        text-align: center;
        cursor: pointer;
        white-space: nowrap;
    }

    .content {
        display: flex;
        flex-direction: column;
        row-gap: 30px;
        justify-content: start;

        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .content p {
        letter-spacing: 1px;
        font-size: 32px;
        font-family: 'Graphik', sans-serif;
        font-weight: 500;
        white-space: nowrap;
        text-align: center;
    }
</style>

<div class="content">
    <img src="images/assets/loading.gif" alt="">
    <!-- <p>Оплата завершена</p>
    <a type="button" onclick="returnToApp()" class="link-to-app" id="link-to-app">Вернуться в магазин</a> -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.shouldClose = true;
    });
    function returnToApp() {
        window.shouldClose = true;
    }

</script>
</body>

</html>
