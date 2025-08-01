import React, { Component } from 'react';
import { createRoot } from 'react-dom/client';


export default class TestComponent extends Component {

    constructor(props) {
        super(props);
        this.state = {
            laoding: true
        }
    }
    componentDidMount() {
        setTimeout(() => {
            this.setState((prevState) => {
                return {
                    ...prevState,
                    laoding: false
                }
            })
        }, 3000)
    }

    render() {
        const { laoding } = this.state;
        if (laoding) {
            return <> Loading...</>
        }
        return (
            <div className="container-fuild">
                <div className="row m-0 p-0">
                    <div className="col-md-12">
                        First Component
                    </div>
                </div>
            </div>
        );

    }
}

if (document.getElementById('TestComponent')) {
    createRoot(document.getElementById('TestComponent')).render(<TestComponent />)
}