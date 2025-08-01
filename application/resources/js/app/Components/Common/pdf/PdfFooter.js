import React, { Component } from 'react'

export default class PdfFooter extends Component {
    render() {
        return (
            <footer className="px-pdf-footer d-none">
                <div className="row">
                    <div data-col-size={5} data-style='{"alignment":"left","fontSize":"8","margin":[15,4,0,0]}'>
                        Mantained By: Company Name
                    </div>
                    <div data-col-size={2} data-style='{"alignment":"center","fontSize":"8","margin":[0,5,0,0]}' className="px-pdf-page-count">
                        *
                    </div>
                    <div data-col-size={5} data-style='{"alignment":"right","fontSize":"8","margin":[0,4,15,0]}'>
                        Mantained By: Company Name
                    </div>
                </div>
            </footer>
        )
    }
}
