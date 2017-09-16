import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import Input from "../components/Input";
import SubmitButton from "../components/SubmitButton";
import Breadcrumbs from "../components/Breadcrumbs";

class CategoriesEdit extends React.Component {
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

    componentDidMount() {
        get('/api/categories', (feedManageResponse) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    item: feedManageResponse.data,
                    title: feedManageResponse.data.title,
                });
            });
        }, (error) => {
            // TODO: handle error
        }, [this.props.match.params.id]);
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
        put('/api/categories', (response) => {
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
        }, [this.state.item.id]);
    };

    getRenderOptions() {
        let breadcrumbLinks = _.isEmpty(this.state.item.title) ? [] : [
            {to: '/categories', label: trans('categories.title')},
            {label: trans('categoriesEdit.title', {title: this.state.item.title})}
        ];

        return {breadcrumbLinks};
    }

    render() {
        let {breadcrumbLinks} = this.getRenderOptions();

        return (
            <div>
                <Breadcrumbs links={breadcrumbLinks}/>

                <h1>
                    {_.isEmpty(this.state.item.title) ? '' :  trans('categoriesEdit.title', {title: this.state.item.title})}
                </h1>

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="title" type="text" label={trans('attributes.title')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.title} value={this.state.title} required/>
                    <SubmitButton label={trans('common.save')} colClass="col-lg-9" disabled={!this.state.canSubmit}/>
                </Formsy.Form>
            </div>
        );
    }
}

export default CategoriesEdit;