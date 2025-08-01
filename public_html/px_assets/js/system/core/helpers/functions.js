let d = 0;
function openNav(id,width=250) {
    document.getElementById(id).style.width = width+"px";
}
function closeNav(id) {
    document.getElementById(id).style.width = "0";
}
function PrintElem(btn, elem, data = '') {
    $("#" + btn).on("click", function () {
        Print(elem)
    })
}
function DirectPrintElem(elem,css="") {
    Print(elem, css);
}
function Print(elem,css="") {
    var divToPrint = document.getElementById(elem);
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><head>');
    newWin.document.write('<link rel="stylesheet" href="' + baseurl + 'px_assets/css/system/lib/bs5/bootstrap.min.css" type="text/css" media="print"/>');
    newWin.document.write('<link rel="stylesheet" href="' + baseurl + 'px_assets/css/system/print/print.css" type="text/css" media="print"/>');
    if(css != "") {
        newWin.document.write(`<style>@media print { ${css} } </style>`);
    }
    newWin.document.write('</head><body onload="window.print()" class="printDivClass">' + divToPrint.innerHTML + '</body></html>');
    newWin.document.close();
}
pdfMake.fonts = {
    Roboto: {
        normal: baseurl + 'px_assets/css/system/fonts/english/RobotoRegular.ttf',
        bold: baseurl + 'px_assets/css/system/fonts/english/RobotoBold.ttf',
        italics: baseurl + 'px_assets/css/system/fonts/english/RobotoItalic.ttf',
        bolditalics: baseurl + 'px_assets/css/system/fonts/english/RobotoBoldItalic.ttf',
    },
    SolaimanLipi: {
        normal: baseurl + 'px_assets/css/system/fonts/bengali/SolaimanLipi.ttf',
        bold: baseurl + 'px_assets/css/system/fonts/bengali/SolaimanLipi-Bold.ttf',
        italics: baseurl + 'px_assets/css/system/fonts/bengali/SolaimanLipi-Italic.ttf',
        bolditalics: baseurl + 'px_assets/css/system/fonts/bengali/SolaimanLipi.ttf',
    }
}
pdfMake.tableLayouts = {
    allDashBorders: {
        hLineStyle: function (i, node) {
            return { dash: { length: 3, space: 5 } }
        },
        vLineStyle: function (i, node) {
            return { dash: { length: 3, space: 5 } }
        },
    },
    admitCardBorder: {
        hLineWidth: function (i, node) {
            return 2;
        },
        vLineWidth: function (i) {
            return 2;
        },
        hLineColor: function (i) {
            return '#252161';
        },
        vLineColor: function (i) {
            return '#252161';
        },
    },
    allBorders: {
        hLineWidth: function (i, node) {
            return 1;
        },
        vLineWidth: function (i) {
            return 1;
        },
        hLineColor: function (i) {
            return 'black';
        },
        paddingLeft: function (i) {
            return 5;
        },
        paddingRight: function (i, node) {
            return 5;
        }
    },
    horizontalBorders: {
        hLineWidth: function (i, node) {
            return 1;
        },
        vLineWidth: function (i) {
            return 0;
        },
        hLineColor: function (i) {
            return '#d1d1d1';
        },
        paddingLeft: function (i) {
            return 8;
        },
        paddingRight: function (i, node) {
            return 8;
        }
    }
};

function MakePdf(op = {}) {
    const { file_name = "file_name", id = "pdf", dataTable = undefined, pdfFonts = [] , tableLayouts=[]} = op;
    let docDefination = { defaultStyle: { font: 'SolaimanLipi' }, ...html_to_pdfmake(op) };
    if (local) {
        console.log(docDefination);
    }
    pdfFonts.map((font) => {
        pdfMake = {
            ...pdfMake,
            fonts: {
                ...pdfMake?.fonts,
                [font?.name]: {
                    normal: font?.n,
                    bold: font?.n,
                    italics: font?.i,
                    bolditalics: font?.bi,
                }
            }
        }
    });
    tableLayouts.map((layout) => {
        pdfMake = {
            ...pdfMake,
            tableLayouts: {
                ...pdfMake?.tableLayouts,
                [layout?.name]: layout?.value
            }
        }
    });
    $("#theDownloadLoader").show();
    pdfMake.createPdf(docDefination).download(file_name + ".pdf", function () {
        const { script, body = {} } = op;
        $("#theDownloadLoader").hide();
        if (script) {
            ajaxRequest({
                element: id,
                script,
                body,
                dataType: "json",
                type: "request",
                afterSuccess: {
                    type: "inflate_response_data"
                }
            });
        }
    });
}
function MakeExcel(op = {}) {
    const { file_name = "file_name", dataTable = undefined, dataSrc = [], columns = [], pdf = [] } = op;
    if (dataSrc.length == 0) {
        data = [];
    }
    op['filterColumn'] = [...columns].filter((item, key) => { return pdf.includes(key); });
    let { body = [], width = [] } = getExcelBody(dataSrc, op);
    if (body.length > 0) {
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet(body);
        for (var i = 0; i < width.length; i++) {
            ws['!cols'] = ws['!cols'] || [];
            ws['!cols'].push({ wch: width[i] });
        }
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        XLSX.writeFile(wb, file_name + '.xlsx');
    }
}
function getSetInput(getInputs, setInputs) {
    getInputs.map((value, key) => {
        let val = $("#" + value).val();
        $("#" + setInputs[key]).val(val);
    });
}

function splitArray(arr, chunkSize) {
    const result = [];
    for (let i = 0; i < arr.length; i += chunkSize) {
        result.push(arr.slice(i, i + chunkSize));
    }
    return result;
}

function escapeHtml(unsafe) {
    return unsafe?.toString().replace(/<[^>]*>/g, "").trim();
}
function dowloadPdf(op = {}) {
    let btn = op?.btn ?? "pdfDownload";
    $("#" + btn).unbind('click');
    $("#" + btn).on("click", function () {
        console.log(op);
        let newOp = { ...op, ...JSON.parse($(this).attr('data-pdf-op') ?? '{"no":"no"}') };
        MakePdf(newOp);
    });
}
function dowloadExcel(op = {}) {
    let btn = op?.btn ?? "excelDownload";
    $("#" + btn).unbind('click');
    $("#" + btn).on("click", function () {
        let newOp = { ...op, ...JSON.parse($(this).attr('data-excel-op') ?? '{"no":"no"}') };
        MakeExcel(newOp);
    });
}
function getPageLang(id = "pageLang") {
    return ($("#" + id).length > 0) ? JSON.parse($("#" + id).val()) : {}
}
function getNestedValue(path, object) {
    return path.split('.').reduce((o, i) => o[i], object)
}
function pageAction(op = {}) {
    $(".viewAction").unbind("click");
    $(".viewAction").on("click", function () {
        const prop = JSON.parse($(this).attr('data-prop'));
        const { page = "addPage", server = "no", method = "post", type = "request", target = "loadEdit", afterSuccess = { type: "load_html" }, dataType = "json" } = prop;
        $(".pages").addClass('d-none').removeClass('d-block');
        $("#" + page).removeClass('d-none').addClass('d-block');
        if (server == "yes") {
            ajaxRequest({ ...prop, type, method, afterSuccess, target, dataType, server });
        }
    });
    $(".closeAction").unbind("click");
    $(".closeAction").on("click", function () {
        let target = $(this).attr('data-cl-action');
        $(".pages").addClass('d-none').removeClass('d-block');
        $("#" + target).removeClass('d-none').addClass('d-block');
    });
}

function fixHeight(c, a, less = 0, add = 0) {
    let arrayBlogdes = [];
    $("." + c).each(function () {
        arrayBlogdes.push($(this).height());
    });
    if (arrayBlogdes.length > 0) {
        let largest = 0;
        for (i = 0; i <= largest; i++) {
            if (arrayBlogdes[i] > largest) {
                largest = arrayBlogdes[i];
            }
        }
        if (largest < 30) {
            $("." + a).css({ "height": ((largest + add) - less) + "px" });
        } else {
            $("." + a).css({ "height": ((largest + add) - less) + "px" });
        }
    }
}

function dynamicDom(op) {
    var { clickId = "", domId = "", cloneId = "", addRemoveclass = "", replaceClass = [] } = op
    $("#" + clickId).on("click", function () {
        var html = $("#" + domId).html();
        var d = $(html).find('.' + addRemoveclass).html('<i class="fa fa-minus p-2 cursor-pointer border rounded-1 required deleteField"></i>').parent().parent().html();
        $("#" + cloneId).append('<div class="row">' + d + '</div>');
        if (replaceClass.length > 0) {
            for (let i = 0; i < replaceClass.length; i++) {
                replaceID(replaceClass[i])
            }
        }
        removeFiled('deleteField');
    });
}

function replaceID(className = "") {
    var collection = $(document).find("." + className)
    if (collection.length > 0) {
        for (let i = 0; i < collection.length; i++) {
            collection[i].id = className + '.' + i + '_error'
        }
    }
}
function removeFiled(removeClass) {
    $("." + removeClass).on("click", function () {
        $(this).parent().parent().parent().remove();
    })
}

function makeArrayUnique(arr, prop) {
    return arr.filter((obj, index, self) =>
        index === self.findIndex((t) => (
            t[prop] === obj[prop]
        ))
    );
}

function sortByKey(array, key, order = 'asc') {
    return array.sort((a, b) => {
        if (order === 'asc') {
            return a[key] < b[key] ? -1 : a[key] > b[key] ? 1 : 0;
        } else if (order === 'desc') {
            return b[key] < a[key] ? -1 : b[key] > a[key] ? 1 : 0;
        }
        return array;
    });
}
function templateChange(table, api, op) {
    $("#sms_template").on('change', function () {
        let length = api.rows('.selected').data().length;
        ajaxRequest({
            script: "admin/sms/management/get/template",
            type: "request",
            dataType: "json",
            body: { template_id: $("#sms_template").val() ?? "", selected: length ?? "" },
            afterSuccess: {
                type: "api_response",
                afterLoad: (op) => {
                    let data = op?.response?.data;
                    $("#sms_header").val(data['template']?.header ?? "");
                    $("#sms_header").removeAttr('readonly');
                    $("#sms_body").removeAttr('readonly');
                    $("#sms_footer").removeAttr('readonly');
                    $("#sms_body").val(data['template']?.body ?? "");
                    $("#sms_footer").val(data['template']?.footer ?? "");
                    $("#left").html(data['extra']?.left ?? "");
                    $("#character").html(data['extra']?.character ?? "");
                    $("#count").html(data['extra']?.count ?? "");
                    $("#encoding").html(data['extra']?.encoding ?? "");
                    $("#charge").html(data['extra']?.charge ?? "");
                }
            },
        });
    })
    $("#sms_header").keyup(function () {
        getSMSKeyUpPoperty(api)
    })
    $("#sms_body").keyup(function () {
        getSMSKeyUpPoperty(api)
    })
    $("#sms_footer").keyup(function () {
        getSMSKeyUpPoperty(api)
    })
}

function tableSelectorClick(table, api, op) {
    $("#" + table + " thead tr th").on("change", 'input[type="checkbox"]', function () {
        if (this.checked) {
            getSMSPoperty(api)
        }
    })
    $("#" + table + " tbody tr td").on("change", 'input[type="checkbox"]', function () {
        if (this.checked) {
            getSMSPoperty(api)
        }
    })

}
function tableSimpleSelectorClick(table, api, op) {
    $("#" + table + " thead tr th").on("change", 'input[type="checkbox"]', function () {
        if (this.checked) {
            getSMSSimplePoperty(api)
        }
    })
    $("#" + table + " tbody tr td").on("change", 'input[type="checkbox"]', function () {
        if (this.checked) {
            getSMSSimplePoperty(api)
        }
    })
}
function sendTemplateSMS(table, api, op) {
    if ($("#frmSendTemplateSMS").length > 0) {
        let rules = {
            sms_body: {
                required: true,
            },
        };
        ajaxRequest({
            element: "frmSendTemplateSMS",
            validation: true,
            script: "admin/sms/management/one/sms/send",
            rules,
            beforeSend: (op, callback) => {
                let newbody = op.body;
                let selected = api.rows('.selected').data().toArray();

                if (selected.length > 0) {
                    selected.map((v, k) => { newbody.append('numbers[]', v.mobile_number) })
                }
                newbody.append('charge', $("#charge").html() ?? 0.00)
                callback({ ...op, body: newbody });
            },
            afterSuccess: {
                type: "inflate_response_data"
            }
        });
    }

}
function sendSimpleSMS(table, api, op) {
    if ($("#frmSendSimpleSMS").length > 0) {
        let rules = {
        };
        ajaxRequest({
            element: "frmSendSimpleSMS",
            validation: true,
            script: "admin/sms/management/many/sms/send",
            rules,
            beforeSend: (op, callback) => {
                let newbody = op.body;
                let selected = api.rows('.selected').data().toArray();
                if (selected.length > 0) {
                    selected.map((v, k) => { newbody.append('numbers[]', v.mobile_number), newbody.append('sms[]', v.sms) })
                }
                newbody.append('charge', $("#charge").html() ?? 0.00)
                callback({ ...op, body: newbody });
            },
            afterSuccess: {
                type: "inflate_response_data"
            }
        });
    }

}
function getSMSKeyUpPoperty(api) {
    let length = api.rows('.selected').data().length;
    ajaxRequest({
        script: "admin/sms/management/get/sms/poperty",
        type: "request",
        dataType: "json",
        body: { header: $("#sms_header").val() ?? "", body: $("#sms_body").val() ?? "", footer: $("#sms_footer").val() ?? "", selected: length ?? "" },
        afterSuccess: {
            type: "api_response",
            afterLoad: (op) => {
                let data = op?.response?.data;
                $("#left").html(data['extra']?.left ?? "");
                $("#character").html(data['extra']?.character ?? "");
                $("#count").html(data['extra']?.count ?? "");
                $("#encoding").html(data['extra']?.encoding ?? "");
                $("#charge").html(data['extra']?.charge ?? "");
            }
        },
    });
}

function getSMSPoperty(api) {
    let selected = api.column(0).checkboxes.selected();
    if (selected.length > 0) {
        ajaxRequest({
            script: 'admin/sms/management/get/selected/sms/poperty',
            type: 'request',
            dataType: 'json',
            body: { header: $("#sms_header").val() ?? "", body: $("#sms_body").val() ?? "", footer: $("#sms_footer").val() ?? "", selected: selected.length ?? "" },
            afterSuccess: {
                type: "api_response",
                afterLoad: (res) => {
                    let data = res?.response?.data;
                    $("#charge").html(data['extra']?.charge ?? "");
                    $("#sms_button").removeAttr('disabled');
                }
            },
        });

    } else {
        $("#charge").html(0.00.toFixed(2));
        $("#sms_button").attr('disabled', true);
    }
}

function getSMSSimplePoperty(api) {
    let data = api.rows('.selected').data().toArray();
    let sms = [];
    if (data.length > 0) {
        data.map((v, k) => { sms.push(v.sms) })
    }
    if (data.length > 0) {
        ajaxRequest({
            script: 'admin/sms/management/get/simple/selected/sms/poperty',
            type: "request",
            dataType: "json",
            body: { sms: sms ?? [] },
            afterSuccess: {
                type: "api_response",
                afterLoad: (res) => {
                    let data = res?.response?.data;
                    $("#encoding").html(data['extra']?.encoding ?? "");
                    $("#count").html(data['extra']?.count ?? "");
                    $("#charge").html(data['extra']?.charge ?? "");
                    $("#sms_button").removeAttr('disabled');
                }
            },
        });
    } else {
        $("#encoding").html("");
        $("#count").html("0");
        $("#charge").html(0.00.toFixed(2));
        $("#sms_button").attr('disabled', true);
    }
}
async function getBase64ImageFromUrl(imageUrl) {
    var res = await fetch(imageUrl);
    var blob = await res.blob();

    return new Promise((resolve, reject) => {
        var reader = new FileReader();
        reader.addEventListener("load", function () {
            resolve(reader.result);
        }, false);

        reader.onerror = () => {
            return reject(this);
        };
        reader.readAsDataURL(blob);
    })
}

function delay(callback, ms = 500) {
    var timer = 0;
    return function () {
        var context = this,
            args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
            callback.apply(context, args);
        }, ms || 0);
    };
}