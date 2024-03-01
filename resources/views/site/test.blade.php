
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/microsoft-signalr/6.0.1/signalr.js"></script>
</head>
<body>
    <h1>Noticias</h1>
    <ul id="listas">
        
    </ul>
    <script>
        const connection = new signalR.HubConnectionBuilder()
        .withUrl("https://api-ecp-dev-notifications.azurewebsites.net/signalR")
        .configureLogging(signalR.LogLevel.Information)
        .build();

    async function start() {
        try {
            await connection.start();
            console.log("SignalR Connected.");
        } catch (err) {
            console.log(err);
            setTimeout(start, 5000);
        }
    };

    connection.onclose(async () => {
        await start();
    });
    connection.on("subscriber-news", (message) => {
        let data = JSON.parse(message)
        let list = $("#listas").html()
        list += `<li>${data.Date} --- ${data.Title}</li>`
        $("#listas").html(list)
    });

    // Start the connection.
    start();
    </script>
</body>
</html>