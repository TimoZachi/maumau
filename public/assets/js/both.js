function setLoading($button, loading, color)
{
    if(color === undefined) color = "info";
    if(loading)
    {
        $button.prop("disabled", true);
        $button.attr("disabled", "disabled");
        $button.prepend('<img src="' + BASE_URL + 'assets/img/loading-small-' + color + '.gif">');
    }
    else
    {
        $button.prop("disabled", false);
        $button.removeAttr("disabled");
        $button.find("img").remove();
    }
}
jQuery(function ($)
{
    var $body = $("body");

    $body.delegate('[data-toggle="modal"]', "click", function (event)
    {
        var $this = $(this);

        if($this.data("load"))
        {
            var $modal = $($this.data("target")),
                $content = $modal.find(".modal-content"),
                url = $this.data("load");

            //start loading
            $content.html("");

            $.ajax({
                url:url,
                type:"GET",
                dataType:"html",
                success:function (data)
                {
                    //stop loading
                    $content.html(data);
                },
                error:function ()
                {
                    //stop loading
                    //show error
                }
            })
        }
        else if($this.data("action"))
        {
            var $modalForm = $($this.data("target") + " form");
            if($modalForm.length)
            {
                $modalForm.attr("action", $this.data("action"));
            }
        }
    });

    function refreshContent($container)
    {
        if($container.data("refresh"))
        {
            $.ajax({
                url:$container.data("refresh"),
                type:"get",
                dataType:"html",
                success:function (data)
                {
                    var $newContainer = $(data),
                        $newContainerContent = $newContainer.hasClass("ajax-content") ?
                            $newContainer :
                            $newContainer.find(".ajax-content");
                    if($newContainerContent.length)
                    {
                        var $ajaxContent = $container.hasClass("ajax-content") ?
                            $container :
                            $container.find(".ajax-content");
                        $ajaxContent.html($newContainerContent.html());
                    }
                }
            });
        }
    }

    $body.delegate('form[data-ajax]', "submit", function (event)
    {
        event.preventDefault();

        var $form = $(this),
            $submit = $form.find('[type="submit"]'),
            $modal = $form.closest(".modal"),
            ajaxRefreshSelector = $form.data("ajax-refresh"),
            request = {
                url:$form.attr("action"),
                type:$form.attr("method"),
                processData:false,
                contentType:false,
                response:""
            };

        $form.find(".form-group").removeClass("has-error");
        $form.find(".help-block").remove();

        var data = $form.serializeArray(),
            fd = new FormData();
        for(var i = 0; i < data.length; i++)
        {
            fd.append(data[i].name, data[i].value);
        }
        if($form.find('input:file').length > 0)
        {
            $form.find("input:file").each(function ()
            {
                if(this.files.length > 0)
                {
                    fd.append(this.name, this.files[0]);
                }
            });
        }
        request.data = fd;

        setLoading($submit, true);
        request.success = function (json) {
            setLoading($submit, false);

            $modal.modal('hide');
            if(ajaxRefreshSelector)
            {
                var $refresh = $(ajaxRefreshSelector);
                $refresh.each(function () {
                    refreshContent($(this));
                });
            }

            if(json.message)
            {
                $.notify(json.message, json.status);
            }


        };
        request.error = function (xhr)
        {
            setLoading($submit, false);
            var json = xhr.responseJSON;

            for(var key in json)
            {
                var $input = $form.find('[name="' + key + '"]'),
                    $fg = $input.closest(".form-group");

                $fg.addClass("has-error");
                $input.after('<p class="help-block">' + json[key].join(",<br>") + '</p>');
            }
        };

        request.headers = {
            "X-CSRF-Token":$form.find('input[name="_token"]').val()
        };
        $.ajax(request);
    });
});