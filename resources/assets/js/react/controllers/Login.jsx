import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {post} from "../base/request";
import {Link} from "react-router-dom";

class Login extends React.Component {
    constructor() {
        super();

        this.state = {email: '', password: '', canSubmit: false, errorMessages: {email: [], password: []}};
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
        post('/api/login', model, (response) => {
            localStorage.setItem('token', response.data.token);
        }, (error) => {
            this.setState((prevState, props) => {
               return Object.assign(prevState, {errorMessages: {email: error.response.data.errors.email, password: error.response.data.errors.password}})
            });
        });
    };

    render() {
        let error = this.state.errorMessage ? (
            <div className="alert alert-danger">{this.state.errorMessage}</div>
        ) : '';

        return (
            <div>
                {error}

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="email" label="E-Mail" errorMessages={this.state.errorMessages.email} value={this.state.email} required/>
                    <Input name="password" type="password" label="Pasword" errorMessages={this.state.errorMessages.password} value={this.state.password} required/>
                    <button className="btn btn-primary" type="submit" disabled={!this.state.canSubmit}>Submit</button>
                </Formsy.Form>
            </div>
        );
    }
}

export default Login;