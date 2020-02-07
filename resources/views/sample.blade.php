<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="manifest" href="manifest.json">
<title>PWA Sample</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<canvas id="stage"></canvas>
<script src="drawer.js"></script>
<script>
// ServiceWorker登録：https://developers.google.com/web/fundamentals/primers/service-workers/?hl=ja
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js').then(function(registration) {
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }).catch(function(err) {
        console.log('ServiceWorker registration failed: ', err);
    });
}
</script>
</body>
</html>