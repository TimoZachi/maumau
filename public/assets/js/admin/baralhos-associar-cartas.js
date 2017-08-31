jQuery(function ($)
{
    $("#associated, #non-associated").sortable({
        connectWith:".deck"
    }).disableSelection();

    var $associated = $("#associated");
    $("#btn-save").click(function (event)
    {
        var $button = $(this),
            ids = [];

        $associated.find("li[data-id]").each(function ()
        {
            ids.push(parseInt(this.dataset.id));
        });

        setLoading($button, true);
        $.ajax({
            url:$associated.data("save"),
            type:"post",
            headers:{
                "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr('content')
            },
            data:{
                card_ids:ids
            },
            dataType:"json",
            success:function (data)
            {
                setLoading($button, false);
            }
        })
    });
});