$("#linkGenerator_slave2").hide();
$("#link").hide();

function loadData() {
    $("#linkGenerator_slave").show();
    $("#linkGenerator_slave2").hide();
    $("#linkGenerator_slave").find("option").remove().end();
    if ($("#linkGenerator_main").val() == "controller") {
        $.each(controller_list, function(i, item) {
            $("#linkGenerator_slave").append($("<option>", {
                value: item,
                text: item
            }));
        });
        $("#link").val($("#linkGenerator_slave").val());
    } else if ($("#linkGenerator_main").val() == "post") {
        $.each(post_list, function(i, item) {
            $("#linkGenerator_slave").append($("<option>", {
                value: item[0],
                text: item[1]
            }));
        });
        $("#link").val($("#linkGenerator_slave").val());
    } else if ($("#linkGenerator_main").val() == "module") {
        $.each(module_list, function(i, item) {
            $("#linkGenerator_slave").append($("<option>", {
                value: item[0],
                text: item[1]
            }));
        });
        $("#link").val($("#linkGenerator_slave").val());
    } else if ($("#linkGenerator_main").val() == "link") {
        $("#linkGenerator_slave2").show();
        $("#linkGenerator_slave").hide();
        $("#link").val($("#linkGenerator_slave2").val());
    }
}
$("#linkGenerator_main").on("change", function() {
    loadData();
});
$("#linkGenerator_slave").on("change", function() {
    $("#link").val($(this).val());
});
$("#linkGenerator_slave2").on("keyup", function() {
    $("#link").val($(this).val());
});

if (auto1 != "") {
    $("select#linkGenerator_main").val(auto1);
    loadData();
    if (auto2.length < 1) {
        $("#linkGenerator_slave2").val(auto1);
        $("#link").val($("#linkGenerator_slave2").val());
        $("#linkGenerator_slave2").show();
        $("#linkGenerator_slave").hide();
        $("#linkGenerator_main").val('link');
    } else {
        $("select#linkGenerator_slave").val(auto2);
        $("#link").val($("select#linkGenerator_slave").val());
    }
}