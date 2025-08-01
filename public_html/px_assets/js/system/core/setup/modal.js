function showModal(op={}) {
    $('.' + m).modal('show');
}
//Edit Data Starts
$('.editmodal').on('show.bs.modal', function (e) {
    var trig = $(e.relatedTarget);
    if (trig.attr("data-bs-target") === ".editmodal") {
        var op = JSON.parse(trig.attr("data-edit-prop"));
        actionModal(op);
    }
});

$('.editmodal').on('hide.bs.modal', function (e) {
    var mod = $("#modalmodule").val();
    if (mod != undefined) {
        switch (mod) {
            case 'redirect':
                window.location.href = window.location.href;
                break;
            case 'fn':
                let callBack = $("#modalmodule").attr('data-callback');
                let body = ($("#modalmodule").attr('data-body')) ? JSON.parse($("#modalmodule").attr('data-body')) : {};
                if(window[callBack] != undefined) {
                    window[callBack](body);
                }
                break;
            default:
                break;
        }
    }
    $(".modal-body, .modal-title").html("");
});
function actionModal(op={}) {
    const {element="NA",script="/", body={},title="No title provided",modalSize=undefined} = op;
    $(".modal-body, .modal-title").html('<img src="' + baseurl + 'statics/images/system/loader6.gif" style="width: 20px;height:20px;"> Loading...');
    let modalSizeClass = "modal-dialog modal-xl";
    if(modalSize) {
        modalSizeClass = `modal-dialog modal-${modalSize}`;
        $(".modal-dialog").removeClass().addClass(modalSizeClass);
    }
    ajaxRequest({
        ...op,
        element,
        script,
        body,
        dataType: "json",
        type: "request",
        target: element,
        title,
        noLoaderImg: true
    },(op)=>{
        let type = typeof(op);
        if (local) {
            console.log(op);
        }
        if (type === "object") {
            const {response,title,modalCallback = undefined,globLoader=true} = op;
            if (response.success) {
                let { extraData = { inflate: G?.lang()?.no_message_return, redirect: window.location.href},view="reached"} = response.data;
                if(globLoader) {
                    inflatesuccess(extraData?.inflate);
                }
                $(".modal-title").html(title);
                $(".modal-body").html(view);
                if(modalCallback) {
                    if(window[modalCallback]) {
                        window[modalCallback](response);
                    }
                }
            }
        } else {
            $('#theGlobalLoader').removeClass("activeGlobalLoader").css({ "display": "none" });
        }
    });
}