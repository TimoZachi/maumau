jQuery(function ($)
{
    var config = window.CONFIG;
    delete window.CONFIG;

    var $sidebar = $("#sidebar"),
        $logo = $(".logo"),
        $btn = $("#btn-toggle-table"),
        $panel = $("#main-panel");

    function windowResize()
    {
        var height = $sidebar.innerHeight() - $panel.offset().top;

        $panel.height(height);
    }

    $(window).on("resize", windowResize);
    windowResize();

    var $table = $("#table-players"),
        $gameTable = $("#game-table");

    var ws = new WSWrapper("ws://" + config.host + ":" + config.port, config.token);
    var user = null;
    function generateRow(user, style)
    {
        if(!user.id) throw new Error("Invalid user");
        return '<tr data-id="' + user.id + '"' + (style ? ' style="' + style + '"' : '') + '>' +
            '<td>' + user.id + '</td>' +
            '<td>' + user.name + '</td>' +
        '</tr>';
    }

    var tableUsers = [];
    function setTable(users)
    {
        if(users === undefined) users = [];
        if(users.length <= 0) $gameTable.hide();
        else
        {
            $gameTable.show();
            for(var i = 0; i < 4; i++)
            {
                var className = '.user' + String(i + 1);
                var $user = $gameTable.find(className);
                if(i in users)
                {
                    $user.find(".frame").html(
                        '<img src="' + users[i].avatar + '" height="100" style="margin-left:10px;">'
                    );
                    $user.find("p").html(users[i].name);
                }
                else
                {
                    $user.find(".frame").html("");
                    $user.find("p").html("");
                }
            }
        }
    }

    function onOpen(event)
    {
        if(event.error)
        {
            $.notify(event.data.message, "error");
        }
        else
        {
            user = event.data.user;
            $table.find("tbody").prepend(
                generateRow(user, "background-color:#cef7d9")
            );
            $.notify("Conectado como: " + user.name, "success");

            $btn.prop("disabled", false);
        }
    }
    ws.addEventListener("open", onOpen);

    function onClose(event)
    {
        user = null;
        $.notify("Connection closed (" + event.code + "): " + event.reason, "error");
    }
    ws.addEventListener("close", onClose);

    function onMessage(event)
    {
        var type = event.messageType,
            data = event.data;
        switch(type)
        {
            case 'user':
                var $main = $table.find('tr[data-id="' + user.id + '"]');
                if(data.action == "connected")
                {
                    $main.after(generateRow(data.user));
                    $.notify(data.user.name + " conectou", "info");
                }
                else if(data.action == "disconnected")
                {
                    $table.find('tbody tr[data-id="' + data.user.id + '"]').fadeOut();
                    $.notify(data.user.name + " desconectou", "info");
                }
                else if(data.action == "online")
                {
                    for(var i = 0; i < data.users.length; i++)
                    {
                        $main.after(generateRow(data.users[i]))
                    }
                }
                break;
            case 'table':
                $btn.prop("disabled", false);
                if(!event.error)
                {
                    if(data.action == "toggle")
                    {
                        if(data.at_table)
                        {
                            $.notify("Você sentou em uma cadeira", "info");
                            $btn.text("Sair da mesa");
                            tableUsers = data.users;
                        }
                        else
                        {
                            $.notify("Você saiu da mesa", "info");
                            $btn.text("Sentar em uma cadeira livre");
                            tableUsers = [];
                        }
                        setTable(tableUsers);
                    }
                    else if(data.action == "at_table")
                    {
                        if(data.at_table)
                        {
                            $.notify(data.user.name + " sentou na mesa", "info");
                            tableUsers.push(data.user);
                        }
                        else
                        {
                            $.notify(data.user.name + " saiu da mesa", "info");
                            var i = 0, found = false;
                            while(!found && i < tableUsers.length)
                            {
                                if(tableUsers[i].id == data.user.id)
                                {
                                    tableUsers.splice(i, 1);
                                    found = true;
                                }
                                i++;
                            }
                        }
                        setTable(tableUsers);
                    }
                    else if(data.action == "load")
                    {
                        ws.removeEventListener("open", onOpen);
                        ws.removeEventListener("close", onClose);
                        ws.removeEventListener("message", onMessage);
                        $.ajax({
                            url:data.url,
                            type:"GET",
                            dataType:"html",
                            success:function (data)
                            {
                                $("#sidebar").remove();
                                $(".game").replaceWith(data);

                                window.initGame(ws, user);
                            }
                        });
                    }
                }
                break;
        }
    }
    ws.addEventListener("message", onMessage);

    ws.connect();

    $btn.on("click", function (event)
    {
        $btn.prop("disabled", true);
        ws.send("table", {
            action:"toggle"
        });
    });
});