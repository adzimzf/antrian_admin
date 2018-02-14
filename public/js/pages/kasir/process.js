var sum = $("#sumTotal").text();
var sum2 = $("#sumTotal2").text();
var DP = $("#uang_muka").val();
var sisaTotal = $("#sumSisa").text();
$(function () {
    $(".harga-satuan").keyup(function () {
        qty = $(this).parent().prev().prev().text();
        harga_satuan = $(this).val() == "" ? 0 : $(this).val();
        isFixed = $(this).attr("isFixed");
        if (isFixed == 0) {
            sl = (($(this).parent().prev().prev().prev().text()).split(" ")[1]).split("x");
            w  = parseInt(sl[0]);
            h  = parseInt(sl[1]);
            //convert to meters
            w  = w / 100;
            h  = h / 100;
            sum = parseInt(qty)*(parseInt(harga_satuan)*w*h);
        }else {
            sum = parseInt(qty)*parseInt(harga_satuan);
        }
        $(this).parent().next().text(sum);
        setTotal();
    });

    $("#uang_muka").keyup(function () {
        setTotal();
    });

    function setTotal() {
        sum = 0;
        $('.sum').each(function(){
            sum += $(this).text() == "" ? 0: parseInt($(this).text());  // Or this.innerHTML, this.innerText
        });
        $("#sumTotal").text(sum);


        setTotalAndSisa()
    }

    function setTotalAndSisa() {
        sum2    = 0;
        sum1     = $("#sumTotal").text() == "" ? 0 : $("#sumTotal").text();
        biSeting = $("#biayaSeting").text() == "" ? 0 :  $("#biayaSeting").text();
        biEdit   = $("#biayaEdit").text() == "" ? 0 : $("#biayaEdit").text();
        sum2     = parseInt(sum1)+parseInt(biSeting)+parseInt(biEdit)
        $("#sumTotal2").text(sum2)

        DP = $("#uang_muka").val() == "" ? 0:parseInt($("#uang_muka").val());
        sisaTotal = sum2-DP;
        $("#sumSisa").text(sisaTotal);
    }

    function getDataDetail() {
        dataDetail = [];
        $(".rows").each(function () {
            harga_satuan = $(this).find(".harga-satuan").val();
            detail_id    = $(this).find(".detail_id").val();
            harga_jumlah = $(this).find(".sum").text();
            dataDetail.push({
                detail_id    : detail_id,
                harga_satuan : harga_satuan,
                harga_jumlah : harga_jumlah
            })
        });
        return JSON.stringify(dataDetail);
    }

    $("#btn-simpan").click(function () {
        simpan(false)
    });
    $("#btn-simpan-cetak").click(function () {
        simpan(true)
    })

    function simpan(cetak) {
        url  = "/kasir/setharga"
        //build form data
        data = new FormData();
        data.append("_token", $("input[name=_token]").val())
        data.append("id", $("#surat-jalan-id").val());
        data.append("total1", sum);
        data.append("total2", sum2);
        data.append("uang-muka", DP);
        data.append("sisa", sisaTotal);
        data.append("data-detail", getDataDetail());

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success     : function (has) {
                if (has == "ok"){
                    h = "<div class=\"alert alert-info alert-dismissable text-center \">";
                    h += "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
                    h += "<strong> Berhasil rubah data </strong>";
                    h += "</div>";
                    $("#alert-field").html(h);
                    if (cetak) {
                        cetakData($("#surat-jalan-id").val())
                    }
                }
            },
            error       : function (XMLHttpRequest, textStatus, errorThrown) {
                t = (XMLHttpRequest+textStatus+errorThrown)
                h = "<div class=\"alert alert-error alert-dismissable text-center \">";
                h += "<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>";
                h += "<strong>"+t+"</strong>";
                h += "</div>";
                $("#alert-field").html(h);
            }
        })
    }



    function cetakData(id) {
        $.get("/kasir/printBon/"+id, function (result) {
            var mywindow = window.open('', 'PRINT', 'height=1700,width=1000');

            mywindow.document.write('<html><head><title>' + document.title  + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write(result);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();
            mywindow.close();

            return true;
        });

    }

})