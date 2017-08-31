window.initGame = function (ws, user)
{
    var BLOCK_SEND = false, CAN_PLAY = false, GAME_FINISHED = false;

    var $gtable = $("#game-table");

    function send(action, data)
    {
        if(BLOCK_SEND) return false;
        BLOCK_SEND = true;

        var sendData = {
            action:action
        };
        if(typeof data == "object") {
            $.extend(sendData, data);
        }
        ws.send("game", sendData);
    }

    function remove()
    {
        $(this).remove();
    }

    function whoseTurn(data)
    {
        $gtable.find('.user').removeClass("current");
        if(data.player.user_id == user.id)
        {
            $.notify("Sua vez", "success");
            $(".cards-panel").addClass("current");
            CAN_PLAY = true;
        }
        else
        {
            CAN_PLAY = false;
            $(".cards-panel").removeClass("current");
            $.notify("Vez de " + data.user.name, "info");
            $gtable.find('.user[data-id="' + data.user.id + '"]').addClass("current");
        }
    }

    function resize($cards)
    {
        $cards.width((($cards.find(".card-back").length - 1) * 10) + 85);
        $cards.closest(".user").width((($cards.find(".card-back").length - 1) * 10) + 215);
    }

    function setCurrentSuit(suit)
    {
        var $suit = $(".center-card").find(".suit"),
            uri = $suit.data("base-uri") + suit.icon;

        $suit.find("img").prop("src", uri);
        $suit.hide().fadeIn(800);
    }

    function setGameClockwise(clockwise)
    {
        var $arrow = $gtable.find(".arrows");
        $arrow.find("img").prop("src", $arrow.data("base-uri") + "arrows-" + (clockwise ? "c" : "cc") + ".png");
    }

    function canPlay()
    {
        if(!CAN_PLAY)
        {
            swal("Ops", "Você não pode jogar ainda!", "error");
            return false;
        }

        return true;
    }

    function selectSuit(callback)
    {
        selectedSuitCallback = callback;
        $('#suits-container').fadeIn('fast');
    }

    function onClose(event)
    {
        user = null;
    }
    ws.addEventListener("close", onClose);

    function onMessage(event)
    {
        var type = event.messageType,
            data = event.data;
        if(type != 'game')
        {
            console.log("Unsupported type: " + type, data);
            return;
        }

        if(data.action == "game_info")
        {
            $("#table-card").html(data.card_html);

            whoseTurn(data.whose_turn);

            setCurrentSuit(data.suit);

            BLOCK_SEND = false;
        }
        else if(data.action == "info")
        {
            $.notify(data.message, "info");
        }
        else if(data.action == "play")
        {
            switch(data.do)
            {
                case 'error':
                    CAN_PLAY = true;
                    swal("Ops", data.message, "error");
                    break;
                case 'card':
                case 'round_finished':
                    if(data.user.id == user.id)
                    {
                        $('.cards-panel .cards .game-card[data-id="' + data.card.id + '"]').fadeOut(800, remove);
                    }
                    else
                    {
                        var $cards = $gtable.find('.user[data-id="' + data.user.id + '"] .cards');
                        $cards.find('.card-back:last-child').remove();
                        resize($cards);
                        $.notify(data.user.name + " jogou", "info");
                    }

                    var $newCard = $(data.card_html); $newCard.hide();
                    $("#table-card").empty().append($newCard);
                    $newCard.fadeIn(800);

                    if(data.suit) setCurrentSuit(data.suit);
                    if(data.whose_turn) whoseTurn(data.whose_turn);
                    if("clockwise" in data) setGameClockwise(data.clockwise);

                    if(data.do == "round_finished")
                    {
                        var msg = ((data.user.id == user.id) ? "Você" : data.user.name) +
                            " venceu esta rodada, deseja iniciar outra?";

                        GAME_FINISHED = true;

                        swal({
                            title:"Terminou",
                            type:data.user.id == user.id ? "success" : "error",
                            text:msg,
                            //showCloseButton:true,
                            showCancelButton:true,
                            closeOnCancel:false,
                            confirmButtonText:"Sim",
                            cancelButtonText:"Voltar para home"
                        }, function (isConfirm)
                        {
                            if(isConfirm)
                            {
                                $(".awaiting-players").show();
                                send("play_again");
                            }
                            else
                            {
                                window.location.href = "/";
                            }
                        });
                    }

                    break;
                case 'draw':
                    if(data.user.id == user.id)
                    {
                        for(var i = 0; i < data.cards.length; i++)
                        {
                            var $card = $(data.cards_html[i]);
                            $(".cards-panel .cards").append($card);
                            $card.hide().fadeIn();
                        }

                        $.notify("Você comprou " + (data.count == 1 ? "uma carta" : (data.count + " cartas")), "info");
                    }
                    else
                    {
                        var $cards = $gtable.find('.user[data-id="' + data.user.id + '"] .cards');
                        for(var i = 0; i < data.count; i++)
                        {
                            $cards.append('<div class="card-back" style="left:' + String($cards.find(".card-back").length * 10) + 'px;"></div>');
                        }
                        resize($cards);
                        $.notify(data.user.name + " comprou " + (data.count == 1 ? "uma carta" : (data.count + " cartas")), "info");
                    }

                    if(data.whose_turn) whoseTurn(data.whose_turn);
                    break;
                case 'last_card':
                    if(data.bt_status) $('.last-card').addClass('active');
                    else $('.last-card').removeClass('active');

                    break;
            }

            BLOCK_SEND = false;
        }
        else if(data.action == "disconnected")
        {
            $.notify(data.user.name + " desconectou", "info");
            $gtable.find('.user[data-id="' + data.user.id + '"]').remove();
        }
        else if(data.action == "game_finished")
        {
            GAME_FINISHED = true;

            var msg = "Todos os outros jogadores desconectaram.";
            if(data.winner.id == user.id) msg += "Você venceu";
            else msg += data.winner.name + " venceu";
            swal("Terminou", msg, "info");
            setTimeout(function ()
            {
                window.location.href = "/";
            }, 4000);
        }
        else if(data.action == "load")
        {
            ws.removeEventListener("close", onClose);
            ws.removeEventListener("message", onMessage);
            $.ajax({
                url:data.url,
                type:"GET",
                dataType:"html",
                success:function (data)
                {
                    $(".game2").replaceWith(data);

                    window.initGame(ws, user);
                }
            });
        }
    }
    ws.addEventListener("message", onMessage);

    var selectedSuitCallback = null;
    $('body').on('click', '#suits-container', function (event)
    {
        if(event.target.id == "suits-container")
        {
            $('#suits-container').fadeOut('fast');
        }
        else
        {
            var $suit = $(event.target).closest(".suit");
            if($suit.length > 0)
            {
                var selectedSuit = $suit.data('id');
                $('#suits-container').fadeOut('fast');

                if(typeof selectedSuitCallback === "function")
                {
                    selectedSuitCallback(selectedSuit);
                    selectedSuitCallback = null;
                }
            }
        }

    });

    // Clique no botao de "maumau"
    $("body").on('click','.last-card',function(event){
        send("last_card",{user_id:user.id});
    });


    $(".cards-panel .cards").on("click", ".game-card", function (event)
    {
        if(!canPlay()) return;

        var $card = $(this),
            id = parseInt($card.data("id")),
            requireSuit = Boolean(parseInt($card.data("require-suit")));

        function play(suitId)
        {
            CAN_PLAY = false;
            send("play", {
                do:"card",
                id:id,
                suit_id:suitId
            });
        }

        if(requireSuit)
        {
            selectSuit(play);
        }
        else play(null);
    });

    $gtable.on("click", ".table-deck", function (event)
    {
        if(!canPlay()) return;

        CAN_PLAY = false;
        send("play", {
            do:"draw"
        });
    });

    send("game_info"); //Requisita a carta da mesa
};
