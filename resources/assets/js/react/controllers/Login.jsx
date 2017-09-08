import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {post} from "../base/request";

class Login extends React.Component {
    constructor() {
        super();

        this.state = {canSubmit: false};
    }

    enableButton = () => {
        this.setState({
            canSubmit: true
        });
    };

    disableButton = () => {
        this.setState({
            canSubmit: false
        });
    };

    submit = (model) => {
        post('/api/login', model, () => {
            console.log('success');
        }, () => {
            console.log('error');
        });
    };

    render() {
        return (
            <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                <Input name="email" required/>
                <button type="submit" disabled={!this.state.canSubmit}>Submit</button>
            </Formsy.Form>
        );
    }
}

export default Login;