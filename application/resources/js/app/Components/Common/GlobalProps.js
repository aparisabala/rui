import React, { Component } from 'react';
import ReactDOM from 'react-dom';
const GP =  {
    dataSelector: $("#dataSelector").val(),
    pageData: $("#pageData").val(),
    warp_svg_text: (text, width, font, y = 0, x=0, l= 0) => {
        var words = text.split(/\s+/);
        var line = [];
        var fina_lines = [];
        var line_number = 0;
        var to_check = "";
        var last = ""
        for (var i = 0; i < words.length; i++) {
            line.push(words[i])
            to_check = line.join(" ");
            if (get_text_width(to_check, font) > width) {
                fina_lines.push(to_check);
                line = [];
                to_check = "";
                last = "";
            } else {
                if (i == words.length - 1) {
                    last += words[i];
                } else {
                    last += words[i] + " ";
                }
            }
        }
        if (last != "") {
            fina_lines.push(last);
        }
        if (fina_lines.length == 1) {
            return (
                <>
                    <tspan x="0" y={y} textAnchor="middle" dy={0} key={"key_"}> {fina_lines[0]}  </tspan>
                </>
            )
        }
        return (
            <>
                {
                    fina_lines.map((v, k) => {
                        return (
                            <tspan x={(k <= l) ? ""+x : "0"} textAnchor="middle" dy={(k == 0) ? 0 : 1 + "em"} key={"key_" + (k + 1)}> {v}  </tspan>
                        )
                    })
                }
            </>
        )

    },
}
function get_text_width(txt, font) {
    var element = document.createElement('canvas');
    var context = element.getContext("2d");
    context.font = font;
    return context.measureText(txt).width;
}
export default GP;