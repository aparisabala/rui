function success(op = {}) {
    const { prev = "loadData", response = null, element = "no", customHideLoader=true, showInflate=true} = op;
    $("#" + element + ' label span').html("").removeClass("required success");
    let type = typeof (response);
    if (local) {
        console.log(response);
    }
    if (type === "object") {
        if (response.success) {
            let { extraData = { inflate: G?.lang()?.no_message_return, redirect: window.location.href }, view = "" } = response.data;
            const { afterLoad = undefined, target = "editView" } = op?.afterSuccess;
            let obj = { ...op, response };
            if (op?.afterSuccess?.type) {
                switch (op?.afterSuccess?.type) {
                    case "inflate_response_data":
                        if(showInflate) {
                            inflatesuccess(extraData?.inflate);
                        }
                        break;
                    case "inflate_reset_response_data":
                        if(showInflate) {
                            inflatesuccess(extraData?.inflate);
                        }
                        fReset(element);
                        break;
                    case "inflate_redirect_response_data":
                        if(showInflate) {
                            inflatesuccess(extraData?.inflate);
                        }
                        timeoutReload(extraData.redirect, 400);
                        break;
                    case "load_html":
                        if(showInflate) {
                            inflatesuccess(extraData?.inflate);
                        }
                        $("#" + target).html(view);
                        break;
                    case "api_response":
                            
                        if(customHideLoader) {
                            hideLoader();
                        }
                        break;

                    default:
                        inflatesuccess(G?.lang()?.action_success);
                        timeoutReload(extraData.redirect, 400);
                        break;
                }
            } else {
                inflatesuccess(G?.lang()?.action_success);
                timeoutReload(extraData.redirect, 400)
            }
            (afterLoad) ? afterLoad(obj,response?.data) : 0;
        } else {
            displayAllErrors(op);
        }
    } else {
        $('#theGlobalLoader').removeClass("activeGlobalLoader").css({ "display": "none" });
    }
}