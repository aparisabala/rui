function ajaxRequest(op = {}, callBack = undefined) {
    if (op == {}) {
        return 0;
    }
    const { type = "n/a", element = "n/a", validation = false } = op;
    if (validation) {
        validate(op, callBack);
    } else {
        switch (type) {
            case "submit":
                $("#" + element).on("submit", function (e) {
                    e.preventDefault();
                    let formData = getRequestData({ ...op, form: this })
                    if (hasInternet()) {
                        op.body = formData
                        send(op, callBack);
                    }
                });
                break;
            case "request":
                if (hasInternet()) {
                    send(op, callBack);
                }
                break;
            default:
                return 0;
        }
    }
   
}

function validate(op = {}, callBack) {
    const { element = "no", rules = {}, messages = {}, afterValidation=undefined } = op;
    let common_message = getMessageBags(rules, G.mgs);
    $("#" + element).validate({
        rules: rules,
        messages: (G.isEmptyObjcet(messages)) ? common_message : messages,
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.next("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid").removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).addClass("is-valid").removeClass("is-invalid");
        },
        submitHandler: function (form) {
            if(afterValidation) {
                afterValidation(form,op);
            } else {
                let data = new FormData(form);
                data.append("_token", csrf_token);
                data.append("client", "w");
                if (hasInternet()) {
                    op.body = data;
                    send(op, callBack);
                }
            }
            return false;
        }
    });
}

function send(op, callBack) {
    const { confirm = false, afterSuccess=undefined,beforeSend=undefined} = op;
    if(afterSuccess?.type && afterSuccess?.type == "load_html" && afterSuccess?.reload || afterSuccess?.type == "api_response") {
        const {target="none"} = afterSuccess;
        $("#"+target).html("");
    }
    if(confirm) {
        confirmAlert(op,(op)=>{ajax(op, (op)=>{ (callBack) ? callBack(op) : success(op)})});
    } else {
        if(beforeSend) {
            beforeSend(op,(op)=>ajax(op, (op)=>{ (callBack) ? callBack(op) : success(op)}));
        } else {
            ajax(op,(op)=>{ (callBack) ? callBack(op) : success(op)});
        }
        
    }
}