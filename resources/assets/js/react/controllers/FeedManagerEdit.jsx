import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import Input from "../components/Input";
import SubmitButton from "../components/SubmitButton";
import Select from "../components/Select";
import Breadcrumbs from "../components/Breadcrumbs";

class FeedManagerEdit extends React.Component {
    constructor() {
        super();

        this.state = {
            item: {},
            categories: [],
            canSubmit: false,
            title: '',
            siteUrl: '',
            feedUrl: '',
            category: '',
            errorMessages: {
                title: [],
                siteUrl: [],
                feedUrl: [],
                category: []
            }
        };
    }

    componentDidMount() {
        get('/api/feed/manage', [this.props.match.params.id], (feedManageResponse) => {
            get('/api/categories', [], (categoriesResponse) => {
                this.setState((prevState, props) => {
                    return Object.assign(prevState, {
                        item: feedManageResponse.data,
                        categories: categoriesResponse.data,
                        title: feedManageResponse.data.title,
                        siteUrl: feedManageResponse.data.site_url,
                        feedUrl: feedManageResponse.data.feed_url,
                        category: feedManageResponse.data.category.id
                    });
                })
            }, (error) => {
                // TODO: handle error
            });
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
        put('/api/feed/manage', {
            title: model.title,
            feed_url: model.feedUrl,
            site_url: model.siteUrl,
            category_id: model.category,
        }, [this.state.item.id], (response) => {
            this.props.history.push('/feed/manage');
        }, (error) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    errorMessages: {
                        title: error.response.data.errors.title,
                        feedUrl: error.response.data.errors.feed_url,
                        siteUrl: error.response.data.errors.site_url,
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

        let breadcrumbLinks = _.isEmpty(this.state.item.title) ? [] : [
            {to: '/feed/manage', label: trans('feedManager.title')},
            {label: trans('feedManagerEdit.title', {title: this.state.item.title})}
        ];

        return {categoryOptions, breadcrumbLinks};
    }

    render() {
        let {categoryOptions, breadcrumbLinks} = this.getRenderOptions();

        return (
            <div>
                <Breadcrumbs links={breadcrumbLinks}/>

                <h1>
                    {_.isEmpty(this.state.item.title) ? '' :  trans('feedManagerEdit.title', {title: this.state.item.title})}
                </h1>

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="title" type="text" label={trans('attributes.title')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.title} value={this.state.title} required/>
                    <Input name="siteUrl" type="text" label={trans('attributes.siteUrl')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.siteUrl} value={this.state.siteUrl} required/>
                    <Input name="feedUrl" type="text" label={trans('attributes.feedUrl')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.feedUrl} value={this.state.feedUrl} required/>
                    <Select name="category" options={categoryOptions} label={trans('attributes.category')} labelColClass="col-lg-3" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.category} value={this.state.category} required/>
                    <SubmitButton label={trans('common.save')} colClass="col-lg-9" disabled={!this.state.canSubmit}/>
                </Formsy.Form>
            </div>
        );
    }
}

export default FeedManagerEdit;