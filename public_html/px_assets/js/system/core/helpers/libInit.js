function SNALL(theclass, h, t, p, id="",op={}) {

    let fonts = op?.fonts ?? []
    $((id == "") ? '.' + theclass : '#' + id).summernote({
        placeholder: p,
        tabsize: t,
        height: h,
        width: "100%",
        disableDragAndDrop: true,
        tabDisable: false,
        followingToolbar: false,
        fontNames: [
            'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 
            'Georgia', 'Helvetica', 'Impact', 'Tahoma', 
            'Times New Roman', 'Verdana', 'Roboto',
            'DevilCandle','Mont','PainterDude'
        ],
        callbacks: {
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable, 3, id);
            },
            onMediaDelete: function($target, editor, $editable) {

                deleteMeia($target[0].src); // img 
            }
        }

    });
}

function StartOwl(the_class, op = {}) {
    let f = {};
    let zero = { items: 1 };
    let six_hundred = { items: 3 };
    let thousand = { items: 4 };
    f.loop = op.loop || true;
    f.margin = op.margin || 10;
    f.nav = op.nav || false;
    f.autoplay = op.autoplay || false;
    f.autoplayTimeout = op.autoplayTimeout || 2000;
    f.responsiveClass = op.responsiveClass || true;
    f.zero = op.zero || zero;
    f.six_hundred = op.six_hundred || six_hundred;
    f.thousand = op.thousand || thousand;
    $('.' + the_class).owlCarousel({
        loop: f.loop,
        margin: f.margin,
        nav: f.nav,
        autoplay: f.autoplay,
        autoplayTimeout: f.autoplayTimeout,
        responsiveClass: f.responsiveClass,
        responsive: {
            0: f.zero,
            600: f.six_hundred,
            1000: f.thousand
        }
    })
}
function StartCounterUp(ele, op = {}) {
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
}
function StartLightGalery(ele, selector) {

    if ($("#" + ele).length > 0) {
        lightGallery(document.getElementById(ele), { selector: '.' + selector });
    }
}
function StartSelect2(selector, op = {}) {
    $('.' + selector).select2({ width: "100%", ...op });
}
function StartSingleSelect2(id, op = {}) {
    $('#' + id).select2({ width: "100%", ...op });
}
function ResetSingleSelect2(id) {
    $("#" + id).val('').trigger('change');
}
function StartPikColor(ele, op = {}) {
    let f = {};
    f.switchable = op.switchable || true;
    $("." + ele).asColorPicker({
        gradient: {
            switchable: f.switchable
        },
    });
}
function makeDataTable(table, op = {}) {
    let f = {};
    let s = [];
    f.glob = (op.glob == undefined) ? false : op.glob;
    f.searching = (op.searching == undefined) ? true : op.searching;
    f.ordering = (op.ordering == undefined) ? false : op.paging;
    f.paging = (op.paging == undefined) ? true : op.paging;
    f.info = (op.info == undefined) ? true : op.info;
    f.responsive = (op.responsive == undefined) ? true : op.responsive;
    f.bLengthChange = (op.bLengthChange == undefined) ? true : op.bLengthChange;
    f.stateSave = (op.stateSave == undefined) ? false : op.stateSave;
    f.pageLength = (op.pageLength === undefined) ? defaultDtSize : op.pageLength;
    f.cache = (op.cache == undefined) ? false : op.cache;
    f.disabled = (op.disabled == undefined) ? [] : op.disabled;
    f.language = {
        url: baseurl + "px_assets/js/system/plugins/dt/locale/" + G.local + ".json"
    }
    if (op.select != undefined) {
        if (op.select) {
            s = [{
                targets: 0,
                checkboxes: {
                    'selectRow': true
                },
                render: function (data, type, row, meta) {
                    if (f.disabled.includes(parseInt(data))) {
                        return '';
                    }
                    return '<input type="checkbox" class="dt-checkboxes">'
                }
            }];
        }
    }
    f.selected = op.selected || [];
    if ($("#" + table).length > 0) {
        let dt = $("#" + table).DataTable({
            paging: f.paging,
            searching: f.searching,
            ordering: f.ordering,
            info: f.info,
            responsive: f.responsive,
            bLengthChange: f.bLengthChange,
            stateSave: f.stateSave,
            pageLength: f.pageLength,
            language: f.language,
            cache: f.cache,
            columnDefs: s,
            select: {
                style: 'multi',
            },
            order: [
                [0, 'DESC']
            ],
            lengthMenu: [
                [10, 50, 100, 500, 1000, 1500, 2000],
                [10, 50, 100, 500, 1000, 1500, 2000]
            ],
            "fnDrawCallback": function (oSettings) {
                let api = this.api();
                if (typeof window[table] === 'function') {
                    let  tr = $("#"+table+' thead tr');
                    let dataSrc = api.rows().data().toArray();
                    let columns = [];
                    if(tr) {
                        let elements = tr[0].children;
                        for (let i = 0; i < elements.length; i++) {
                            let title = elements[i].textContent.trim();
                            let styles = JSON.parse(elements[i].getAttribute('data-style')) ?? {};
                            let pdfWidth = styles?.pdfWidth ?? "*";
                            columns.push({title, data: "col_"+i,pdfWidth});
                        }
                        dataSrc = [...dataSrc].map((rows,rowIndex)=>{
                            let ob= {};
                            rows.map((col,index)=>{
                                ob['col_'+index] = rows[index];
                            });
                            return ob;
                        })

                    }
                    let newOp = {...op, dataSrc: [...dataSrc],columns}
                    window[table](table, api, newOp);
                }
            }
        });
        selectAction(table, dt);
    }
}
function makeAjaxDataTable(table, op = {}) {
    console.log(op);
    let f = {};
    let s = [];
    f.glob = (op.glob == undefined) ? false : op.glob;
    f.searching = (op.searching == undefined) ? true : op.searching;
    f.ordering = (op.ordering == undefined) ? false : op.ordering;
    f.paging = (op.paging == undefined) ? true : op.paging;
    f.info = (op.info == undefined) ? true : op.info;
    f.pageLength = (op.pageLength === undefined) ? defaultDtSize : op.pageLength;
    f.responsive = (op.responsive == undefined) ? true : op.responsive;
    f.bLengthChange = (op.bLengthChange == undefined) ? true : op.bLengthChange;
    f.stateSave = (op.stateSave == undefined) ? false : op.stateSave;
    f.cache = (op.cache == undefined) ? false : op.cache;
    f.url = op.url || "";
    f.columns = op.columns || [];
    f.body = op.body || {};
    f.language = {
        url: baseurl + "px_assets/js/system/plugins/dt/locale/" + G.local + ".json"
    }
    if (op.select != undefined) {
        if (op.select) {
            s = [{
                targets: 0,
                checkboxes: {
                    'selectRow': true
                },
                render: function (data, type, row, meta) {
                    if (row?.can_select == "no") {
                        return '';
                    }
                    return '<input type="checkbox" class="dt-checkboxes">'
                }
            }];
        }
    }
    f.selected = op.selected || [];
    let post_data = { _token: csrf_token };
    for (let key in f.body) {
        post_data[key] = f.body[key]
    }
    if ($("#" + table).length > 0) {
        let dt = $("#" + table).DataTable({
            paging: f.paging,
            searching: f.searching,
            searchDelay: 500,
            serverSide: true,
            "bStateSave": true,
            ordering: f.ordering,
            info: f.info,
            responsive: f.responsive,
            bLengthChange: f.bLengthChange,
            stateSave: f.stateSave,
            cache: f.cache,
            language: f.language,
            pageLength: f.pageLength,
            columnDefs: s,
            processing: "<span class='fa-stack fa-lg'>\n\
                    <i class='fa fa-spinner fa-spin fa-stack-2x fa-fw'></i>\n\
               </span>&nbsp;&nbsp;&nbsp;&nbsp;Processing ...",
            serverSide: true,
            lengthMenu: [
                [10, 50, 100, 500, 1000, 1500, 2000],
                [10, 50, 100, 500, 1000, 1500, 2000]
            ],
            ajax: {
                type: "POST",
                url: baseurl + f.url,
                data: post_data,
                dataSrc: function (data) {
                    op = { ...op, data: data, dataSrc: data.data }
                    if (local) {
                        console.log(data.data);
                    }
                    return data.data;
                },
                error: function (response) {
                    console.log(response);
                }
            },
            columns: f.columns,
            select: {
                style: 'multi'
            },
            order: [
                [0, 'DESC']
            ],
            "fnDrawCallback": function (oSettings) {
                let api = this.api();
                if (typeof window[table] === 'function') {
                    window[table](table, api, op);
                }
            }
        });
        selectAction(table, dt, op);
    }

}
function selectAction(table, dt, op) {

    $('#' + table + ' tbody').on('click', 'input[type="checkbox"]', function (e) {
        let $row = $(this).closest('tr');
        if (this.checked) {
            $row.addClass('selected');
        } else {
            $row.removeClass('selected');
        }
        showSelected(dt, op);
        e.stopPropagation();
    });
    $('#' + table + ' thead', dt.table().container()).on('click', 'input[type="checkbox"]', function (e) {
        if (this.checked) {
            let cb = $('#' + table + ' tbody input[type="checkbox"]');
            cb.prop('checked', true);
            cb.parent().parent().addClass('selected');
        } else {
            let cb = $('#' + table + ' tbody input[type="checkbox"]');
            cb.prop('checked', false);
            cb.parent().parent().removeClass('selected');
        }
        showSelected(dt,op);
        e.stopPropagation();
    });
}
function showSelected(dt,op={}) {
    let count = dt.rows('.selected').data().length;
    if (count == "0") {
        $("#show_selected").html('');
        $("#show_selected_base").css({ marginLeft: "-500px" });
    } else {
        $("#show_selected_base").css({ marginLeft: 0 });
        $("#show_selected").html('Selected: ' + count)
    }
    if (op?.onSelectRows) {
        op?.onSelectRows(dt,op);
    }
}
function getDtData(type, dt, col, c) {
    let rdata = [];
    dt.column(col).nodes().to$().each(function () {
        switch (type) {
            case "input":
                rdata.push($(this).find("." + c).val());
                break;
            case "td":
                rdata.push($(this).text().trim());
                break;
            default:
                break;
        }
    });
    return rdata;
}

function dp(op = {}) {
    $('.dp').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        scrollMonth: false,
        scrollInput: false,
        ...op
    });
}
function tp(op = {}) {
    $('.tp').datetimepicker({
        datepicker: false,
        format: 'h:i A',
        showSecond: false,
        validateOnBlur: false,
        validateOnChange: false,
        step: 5,
        ...op
    });
}
$.fn.monthYearPicker = function (op) {
    options = $.extend({
        ...op,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        showAnim: "",
    });
    function hideDaysFromCalendar() {
        var thisCalendar = $(this);
        $('.ui-datepicker-calendar').detach();
        // Also fix the click event on the Done button.
        $('.ui-datepicker-close').unbind("click").click(function () {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            thisCalendar.datepicker('setDate', new Date(year, month, 1));
        });
    }
    $(this).datepicker(options).focus(hideDaysFromCalendar);
}

function myp(op = {}) {
    $(".myp").monthYearPicker(op)
}


function dpt(op = {}) {
    $('.dpt').datetimepicker({
        format: 'Y-m-d h:i A',
        showSecond: false,
        validateOnBlur: false,
        validateOnChange: false,
        step: 5,
        ...op
    });
}