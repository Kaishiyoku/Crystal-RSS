import React from "react";
import {get, post} from '../base/request';
import trans from "../base/translate";
import Input from "../components/Input";
import SubmitButton from "../components/SubmitButton";
import Select from "../components/Select";
import _ from 'lodash';
import {Link} from "react-router-dom";
import Breadcrumbs from "../components/Breadcrumbs";

class FeedManagerCreate extends React.Component {
    constructor() {
        super();

        this.state = {
            item: {},
            categories: [],
            canSubmit: false,
            siteOrFeedUrl: '',
            category: '',
            errorMessages: {
                siteOrFeedUrl: [],
                category: []
            }
        };
    }

    componentDidMount() {
        get('/api/categories', [], (categoriesResponse) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    categories: categoriesResponse.data,
                    category: _.first(categoriesResponse.data).id
                });
            })
        }, (error) => {
            // TODO: handle error
        });
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
        post('/api/feed/manage', {
            site_or_feed_url: model.siteOrFeedUrl,
            category_id: model.category,
        }, (response) => {
            this.props.history.push('/feed/manage');
        }, (error) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    errorMessages: {
                        siteOrFeedUrl: error.response.data.errors.site_or_feed_url,
                        category: error.response.data.errors.category_id
                    }
                })
            });
        });
    };

    getRenderOptions() {
        let categoryOptions = this.state.categories.map((category) => {
            return {value: category.id, label: category.title};
        });

        let breadcrumbLinks = [
            {to: '/feed/manage', label: trans('feedManager.title')},
            {label: trans('feedManagerCreate.title')}
        ];

        return {categoryOptions, breadcrumbLinks};
    }

    render() {
        let {categoryOptions, breadcrumbLinks} = this.getRenderOptions();

        return (
            <div>
                <Breadcrumbs links={breadcrumbLinks}/>

                <h1>
                    {trans('feedManagerCreate.title')}
                </h1>

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="siteOrFeedUrl" type="text" label={trans('attributes.siteOrFeedUrl')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.siteOrFeedUrl} value={this.state.siteOrFeedUrl} required/>
                    <Select name="category" options={categoryOptions} label={trans('attributes.category')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.category} value={this.state.category} required/>
                    <SubmitButton label={trans('common.save')} colClass="col-lg-10" disabled={!this.state.canSubmit}/>
                </Formsy.Form>
            </div>
        );
    }
}

export default FeedManagerCreate;