$(function () {
    $(".btn-process").click(function () {
        $.get("/operator/process/setDone/ajax", {id:$(this).attr("id")}, function (result) {
            location.reload()
        })
    })
})