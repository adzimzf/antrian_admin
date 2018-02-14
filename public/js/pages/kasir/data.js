$(function () {
    $("#no-bon, #nama").keyup(function () {
        getData()
    })
    $(window).load(function () {
        getData()
    })

    function getData() {
        url   = "/kasir/data/ajax"
        $.ajax({
            "url" : url,
            "type": "GET",
            "data": {
                noBon : $("#no-bon").val(),
                nama  : $("#nama").val()
            },
            "success" : function (result) {
                if(result.success == "ok") {
                    td = "<tr><td class='text-center' colspan='6'>Tidak Ada Data</td></tr>"
                    if (result.data.length > 0){
                        td = ""
                    }
                    console.log(result.data.length)
                    $.each(result.data, function (index, val) {
                        td += "<tr>"
                        td += "<td>"+(index+1)+"</td>\n" +
                            "<td>"+val.id+"</td>\n" +
                            "<td>"+val.nama+"</td>\n" +
                            "<td>\n" +
                            "    <div class=\"progress progress-xs\">\n" +
                            "        <div class=\"progress-bar progress-bar-success\" style=\"width:"+val.proses+"%\"></div>\n" +
                            "    </div>\n" +
                            "</td>\n"
                        td += "<td>"
                        if (val.total2 != 0) {
                            persen = Math.round(parseInt(val.uang_muka)/parseInt(val.total2)*100)
                            if (persen < 30) {
                                td +="<span class=\"badge bg-red\">"+persen+"%</span>";
                            }else if (persen < 70) {
                                td +="<span class=\"badge bg-orange\">"+persen+"%</span>";
                            }else if (persen < 90) {
                                td +="<span class=\"badge bg-blue\">"+persen+"%</span>";
                            }else if (persen == 100) {
                                td +="<span class=\"badge bg-green\">"+persen+"%</span>";
                            }

                        }else{
                            td += "<span class=\"badge bg-red\">0%</span>"
                        }
                        td += "</td>"

                        td += "<td>\n" +
                            "<a href=\"/kasir/process/"+val.id+"\" class=\"btn btn-primary\">Process</a>\n" +
                            "<a href=\"/kasir/detail/"+val.id+"\" class=\"btn btn-primary\">Detail</a>"
                        td += "</td>"

                        td += "</tr>"
                    })
                    $("#tbody").html(td)
                }else{
                    tr = "<tr><td class='text-center' colspan='6'>Tidak Ada Data</td></tr>";
                    $("#tbody").html(tr)
                }
            },
            "error"   : function () {

            }
        })
    }
})