import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {post} from "../base/request";
import {Link, Redirect} from "react-router-dom";
import SubmitButton from "../components/SubmitButton";
import trans from "../base/translate";

class Login extends React.Component {
    constructor() {
        super();

        this.state = {
            email: '',
            password: '',
            canSubmit: false,
            errorMessages: {
                email: [],
                password: []
            },
            isRedirect: false
        };
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

            this.setState((prevState, props) => {
               return Object.assign(prevState, {
                   isRedirect: true
               })
            });
        }, (error) => {
            this.setState((prevState, props) => {
               return Object.assign(prevState, {
                   errorMessages: {
                       email: error.response.data.errors.email,
                       password: error.response.data.errors.password
                   }
               })
            });
        });
    };

    render() {
        let redirect = this.state.isRedirect ? <Redirect to="/feed"/> : '';

        return (
            <div>
                <div className="d-flex justify-content-center">
                    <img src="img/logo.svg" className="logo"/>
                </div>

                <div className="d-flex justify-content-center mb-5">
                    <img src="img/lettering.svg" className="lettering img-fluid"/>
                </div>

                <div className="row justify-content-md-center">
                    <div className="col col-lg-8">
                        <div className="card border-primary">
                            <h4 className="card-header text-white bg-primary">
                                {trans('login.title')}
                            </h4>

                            <div className="card-body">
                                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                                    <Input name="email" type="email" label={trans('attributes.email')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.email} value={this.state.email} required/>
                                    <Input name="password" type="password" label={trans('attributes.password')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.password} value={this.state.password} required/>
                                    <SubmitButton label={trans('login.submit')} colClass="col-lg-8" disabled={!this.state.canSubmit}/>
                                </Formsy.Form>
                            </div>
                        </div>
                    </div>
                </div>

                {redirect}
            </div>
        );
    }
}

export default Login;