import React from "react";
import {del} from "../base/request";

class Logout extends React.Component {
    constructor() {
        super();

        this.state = {};
    }

    componentDidMount() {
        del('/api/store/clear', (response) => {
            localStorage.clear();

            this.props.history.push('/');
        }, (error) => {
            // TODO: handle error
        });
    }

    render() {
        return (
            <div>
            </div>
        )
    }
}

export default Logout;