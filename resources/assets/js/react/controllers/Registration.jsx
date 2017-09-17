import React from "react";
import Input from "../components/Input";
import Formsy from 'formsy-react';
import {get, post} from "../base/request";
import SubmitButton from "../components/SubmitButton";
import trans from "../base/translate";
import user$ from "../base/stores/user$";

class Registration extends React.Component {
    constructor() {
        super();

        this.state = {
            name: '',
            email: '',
            password: '',
            passwordConfirmation: '',
            canSubmit: false,
            errorMessages: {
                name: [],
                email: [],
                password: [],
                passwordConfirmation: []
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
        post('/api/register', (response) => {
            this.props.history.push('/');
        }, (error) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    errorMessages: {
                        name: error.response.data.errors.name,
                        email: error.response.data.errors.email,
                        password: error.response.data.errors.password,
                        passwordConfirmation: error.response.data.errors.password_confirmation
                    }
                })
            });
        }, model)
    };

    render() {
        return (
            <div>
                <div className="row justify-content-md-center">
                    <div className="col col-lg-8">
                        <div className="card border-primary">
                            <h4 className="card-header text-white bg-primary">
                                {trans('registration.title')}
                            </h4>

                            <div className="card-body">
                                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                                    <Input name="name" type="text" label={trans('attributes.name')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.name} value={this.state.name} required/>
                                    <Input name="email" type="email" label={trans('attributes.email')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.email} value={this.state.email} required/>
                                    <Input name="password" type="password" label={trans('attributes.password')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.password} value={this.state.password} required/>
                                    <Input name="password_confirmation" type="password" label={trans('attributes.passwordConfirmation')} labelColClass="col-lg-4" inputColClass="col-lg-6" errorMessages={this.state.errorMessages.passwordConfirmation} value={this.state.passwordConfirmation} required/>
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

export default Registration;