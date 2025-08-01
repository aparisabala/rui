csrf_token = $('meta[name="_token"]').attr('content');
uploadurl = $("#service_domain").val() + "/summernote/";
G = {
    ed: {
        file_name: "text",
        pdf: {
            orientation: "landscape",
            size: "A4",
            margin: [15, 75, 15, 20],
            left_mar: 15,
            right_mar: 15,
            display_base: 9.5,
            display_one: 7,
            display_two: 7.5,
            display_three: 8.5,
            display_four: 11.5,
        },
    },
    CN: (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    l: $("#l").val(),
    deleteAll: (op) => {
        const { element = "N/A", script = "/", extra = {}, api = [], dataType = "json", type = "request", afterSuccess = { type: "inflate_redirect_response_data" }, tableLoadType="ajax" } = op;
        $("." + element).unbind("click");
        $("." + element).on("click", function () {
            let rows_selected = api.rows('.selected').data().toArray();
            if (rows_selected.length > 0) {
                let d = {};
                if (extra != "no") {
                    d["extra"] = extra;
                }
                let bodyData =  $(this).attr('data-bodyData') ?? null;
                if($(this).attr('data-bodyData')) {
                    bodyData = JSON.parse(bodyData);
                    d = {
                        ...d,
                        bodyData,
                    }
                }
                let ids = [];
                if(tableLoadType == "ajax") {
                    rows_selected.map((v, k) => { ids.push(v?.id) })
                } else {
                    rows_selected.map((v, k) => { ids.push(v[0]) })
                }
                d["ids"] = ids;
                ajaxRequest({
                    ...op,
                    element,
                    script,
                    body: d,
                    dataType,
                    type,
                    afterSuccess
                });

            } else {
                showAlert(`<span class="text-danger fs-14">${G.mgs.no_data_selected}</span>`, "");
            }
        });
    },
    updateAll: (op = {}) => {
        const { element = "N/A", script = "/", extra = {}, api = [], dataType = "json", type = "request", afterSuccess = { type: "inflate_redirect_response_data" }, dataCols = [] } = op;
        $("." + element).unbind("click");
        $("." + element).on("click", function () {
            let d = {};
            if (extra != "no") {
                d["extra"] = extra;
            }
            let colData = {};
            dataCols.items.map((colValue, colKey) => {
                colValue.data = getDtData(colValue.type, api, colValue.index, colValue.name);
                return colValue;
            });
            let keyDataItem = dataCols.items.find((value) => { return value.name == dataCols.key });
            if (keyDataItem) {
                let keyData = keyDataItem.data;
                dataCols.items.map((colValue, colKey) => {
                    let dataArray = {};
                    colValue.data.map((value, key) => {
                        dataArray[keyData[key]] = value;
                    });
                    d[colValue.name] = dataArray;
                });
            }
            ajaxRequest({
                ...op,
                element,
                script,
                body: d,
                dataType,
                type,
                afterSuccess
            });
        });

    },
    local: document.getElementById('locale').value,
    mgs: JSON.parse(document.getElementById('lang').value),
    digits: JSON.parse(document.getElementById('digits').value),
    attributes: JSON.parse(document.getElementById('attributes').value),
    pageLang: ($("#pageLang").length > 0) ? JSON.parse($("#pageLang").val()) : null,
    lang: function (op = {}) {
        let ob = {};
        let lang = this.mgs;
        for (const langKey in lang) {
            if (Object.hasOwnProperty.call(lang, langKey)) {
                const langElement = lang[langKey];
                if (typeof (langElement) == "object") {
                    for (const key in langElement) {
                        if (Object.hasOwnProperty.call(langElement, key)) {
                            const element = langElement[key].toString();
                            ob[key] = this.getMatchedString(element, op);
                        }
                    }
                }
                if (typeof (langElement) == "string") {
                    ob[langKey] = this.getMatchedString(langElement, op);
                }
            }
        }
        return ob;
    },
    getMatchedString: function (element, op) {
        let str = element.replace(/:digits|:type|:attribute/gi, function (matched) {
            let s = op[matched.split(":")[1]];
            return (s == void 0) ? matched : s;
        });
        return str;
    },
    isEmptyObjcet: (obj) => {
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                return false;
            }
        }
        return true;
    },
    monthNames: [
        "Jan", "Feb", "Mar",
        "Apr", "May", "Jun", "Jul",
        "Aug", "Sep", "Oct",
        "Nov", "Dec"
    ],
}
$(".dropdown-menu").click(function (e) {
    e.stopPropagation();
});

function sendFile(file, editor, welEditable, ul = 3, id = '') {
    console.log(id);
    data = new FormData();
    data.append("file", file);
    data.append("_token", csrf_token)
    data.append("uploadurl", uploadurl);
    data.append("ul", ul)
    $.ajax({
        data: data,
        type: "POST",
        url: baseurl + 'glob/uploadsummernote',
        cache: false,
        contentType: false,
        processData: false,
        success: function (sdata) {
            if (sdata === "size") {
                alert("Image size must be below 300kb");
            } else if (sdata === "error") {
                alert("Image format not acceptable");
            } else if (sdata === "type") {
                alert("jpg, png or gif accepted only");
            } else {
                let image = $('<img>').attr('src', baseurl + 'uploads/app/' + uploadurl + sdata);
                $('#' + id).summernote("insertNode", image[0]);
            }
        }
    })
    .fail(function (xhr, status, error, req) {
        // just in case posting your form failed
        console.log(xhr.responseText);
    });
}

function deleteMeia(img) {
    let file = img.substr(img.lastIndexOf("/") + 1);
    $.ajax({
        data: { img: file, _token: csrf_token },
        type: "POST",
        url: baseurl + 'glob/deletesummernote',
        success: function (sdata) {
            if (sdata === "error") {
                alert("Img not found, try refresh");
            }
        }
    })
    .fail(function (xhr, status, error, req) {
        // just in case posting your form failed
        console.log(xhr.responseText);
    });
}
