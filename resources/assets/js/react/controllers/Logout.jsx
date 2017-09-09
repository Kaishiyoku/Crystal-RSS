import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {post} from "../base/request";
import {Link, Redirect} from "react-router-dom";

class Logout extends React.Component {
    constructor() {
        super();

        this.state = {isRedirect: false};
    }

    componentDidMount() {
        localStorage.clear();

        this.setState({isRedirect: true});
    }

    render() {
        let redirect = this.state.isRedirect ? <Redirect to="/"/> : '';

        return (
            <div>
                {redirect}
            </div>
        )
    }
}

export default Logout;