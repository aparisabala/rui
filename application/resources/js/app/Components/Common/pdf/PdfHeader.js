import React from 'react'

export default function PdfHeader({ ed }) {
    return (
        <header className="px-pdf-header d-none" data-style='{"margin":[15,5,15,0]}'>
            <div className="row">
                <div data-col-size={1} data-style='{"alignment":"left","fontSize":"7"}'>
                    {ed?.currentDate}
                </div>
                <div data-col-size={10}>
                    <h1 data-style='{"alignment":"center","fontSize":"10"}'>
                        {ed?.ins?.service_name}
                    </h1>
                    <h6 data-style='{"alignment":"center","fontSize":"8"}'>
                        {ed?.ins?.address}
                    </h6>
                </div>
                <div data-col-size={1} className="px-pdf-page-count" data-style='{"alignment":"right","fontSize":"7"}'>*</div>
            </div>
            <div className="row">
                <div data-col-size={12} data-style='{"alignment":"left","fontSize":"8","margin":[0,6,0,0],"bold":true}' > {ed?.docTitle}</div>
            </div>
        </header>
    )
}
