import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {get, post} from "../base/request";
import SubmitButton from "../components/SubmitButton";
import trans from "../base/translate";
import user$ from "../base/stores/user$";

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
            }
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
        post('/api/login', model, (loginResponse) => {
            get('/api/user', [], (userResponse) => {
                localStorage.setItem('token', loginResponse.data.token);

                user$.next(userResponse.data);

                history.push('/feed');
            }, (error) => {
                // TODO: handle error
            }, loginResponse.data.token);
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
            </div>
        );
    }
}

export default Login;