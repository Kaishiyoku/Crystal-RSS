import React from "react";
import {get, post} from '../base/request';
import trans from "../base/translate";
import Input from "../components/Input";
import SubmitButton from "../components/SubmitButton";
import Select from "../components/Select";
import _ from 'lodash';
import {Link} from "react-router-dom";
import Breadcrumbs from "../components/Breadcrumbs";

class CategoriesCreate extends React.Component {
    constructor() {
        super();

        this.state = {
            item: {},
            canSubmit: false,
            title: '',
            errorMessages: {
                title: []
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
        post('/api/categories', (response) => {
            this.props.history.push('/categories');
        }, (error) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    errorMessages: {
                        title: error.response.data.errors.title
                    }
                })
            });
        }, {
            title: model.title
        });
    };

    getRenderOptions() {
        let breadcrumbLinks = [
            {to: '/categories', label: trans('categories.title')},
            {label: trans('categoriesCreate.title')}
        ];

        return {breadcrumbLinks};
    }

    render() {
        let {breadcrumbLinks} = this.getRenderOptions();

        return (
            <div>
                <Breadcrumbs links={breadcrumbLinks}/>

                <h1>
                    {trans('categoriesCreate.title')}
                </h1>

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="title" type="text" label={trans('attributes.title')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.title} value={this.state.title} required/>
                    <SubmitButton label={trans('common.save')} colClass="col-lg-10" disabled={!this.state.canSubmit}/>
                </Formsy.Form>
            </div>
        );
    }
}

export default CategoriesCreate;