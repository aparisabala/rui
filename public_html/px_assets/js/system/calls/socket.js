$(document).ready(function() {
    //socket
    if(socket) {
        socket.on('thecon', function(data) {
            $("#sk").css({ color: "green" });
        });
        if (!socket.connected) {
            $("#sk").css({ color: "red" });
        }
        socket.on('notification', function(data) {
            switch (data.mod) {
                default:
                    $("#notification").append(data.html);
                    break;
            }
        });
        socket.on('message', function(data) {
        })
    }
});