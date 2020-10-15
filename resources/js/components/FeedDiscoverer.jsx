import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import 'whatwg-fetch';
import LoadingButton from "./LoadingButton";
import {post} from '../core/request/request';
import Button from './Button';
import classNames from 'classnames';

class FeedDiscoverer extends Component {
    static propTyes = {
        url: PropTypes.string.isRequired,
        token: PropTypes.string.isRequired,
        siteInputId: PropTypes.string.isRequired,
        feedInputId: PropTypes.string.isRequired,
        feedDiscoverButtonContainerId: PropTypes.string.isRequired,
        translations: PropTypes.object.isRequired,
    };

    state = {
        isButtonDisabled: true,
        isLoading: false,
        discoveredFeedUrls: [],
        showNoFeedUrlsFoundError: false,
        siteInputElement: null,
        feedInputElement: null,
    };

    componentDidMount() {
        if (this.state.siteInputElement === null && this.state.feedInputElement === null) {
            this.setState((prevState, props) => {
                const siteInputElement = document.getElementById(this.props.siteInputId);
                siteInputElement.onkeyup = this.handleSiteInputElementChange;
                siteInputElement.onchange = this.handleSiteInputElementChange;

                const feedInputElement = document.getElementById(this.props.feedInputId);
                feedInputElement.onkeyup = this.handleFeedInputElementChange;
                feedInputElement.onchange = this.handleFeedInputElementChange;

                const isButtonDisabled = siteInputElement.value === '';

                return Object.assign({}, prevState, {siteInputElement, feedInputElement, isButtonDisabled})
            });
        }
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        ReactDOM.render(
            <LoadingButton
                isLoading={this.state.isLoading}
                disabled={this.state.isButtonDisabled}
                onClick={this.handleDiscoverFeedClick}
                className="btn btn-secondary btn-with-input"
            >
                {this.props.translations.discover_feeds}
            </LoadingButton>, document.getElementById(this.props.feedDiscoverButtonContainerId));
    }

    handleSiteInputElementChange = (event) => {
        this.setState((prevState, props) => {
            const isButtonDisabled = prevState.siteInputElement.value === '';

            const feedInputElement = prevState.feedInputElement;
            feedInputElement.value = null;

            return Object.assign({}, prevState, {isButtonDisabled, discoveredFeedUrls: [], feedInputElement});
        });
    };

    handleFeedInputElementChange = (event) => {
        this.setState((prevState, props) => {
            // const siteInputElement = prevState.siteInputElement;
            // siteInputElement.value = null;

            return Object.assign({}, prevState, {isButtonDisabled: true, discoveredFeedUrls: []/*, siteInputElement*/});
        });
    };

    handleDiscoverFeedClick = () => {
        this.setState((prevState, props) => {
            return Object.assign({}, prevState, {isLoading: true});
        }, () => {
            return post(this.props.url, {url: this.state.siteInputElement.value})
                .then((response) => {
                    this.setState((prevState, props) => {
                        return Object.assign({}, prevState, {isLoading: false, discoveredFeedUrls: response.data, showNoFeedUrlsFoundError: response.data.length === 0});
                    });
                })
                .catch((error) => {
                    this.setState((prevState, props) => {
                        return Object.assign({}, prevState, {isLoading: false, showNoFeedUrlsFoundError: true});
                    });
                });
        });
    };

    handleSelectUrlClick = (url) => () => {
        const feedInputElement = this.state.feedInputElement;
        feedInputElement.value = url;

        this.setState((prevState, props) => {
            return Object.assign({}, prevState, {feedInputElement});
        });
    };

    renderDiscoveredFeedUrls() {
        if (this.state.discoveredFeedUrls.length === 0) {
            return null;
        }

        return (
            <div className="card py-1">
                {this.state.discoveredFeedUrls.map((url) => {
                    const classes = classNames('dropdown-item w-full text-left', {
                        'dropdown-item-active': this.state.feedInputElement.value === url,
                    });

                    return (
                        <Button key={url} className={classes} onClick={this.handleSelectUrlClick(url)} title={url}>
                            {url}
                        </Button>
                    );
                })}
            </div>
        );
    }

    renderNoFeedUrlsFoundErrorMessage() {
        return this.state.showNoFeedUrlsFoundError ? (
            <div className="text-danger">{this.props.translations.no_feeds_found}</div>
        ) : null;
    }

    render() {
        return (
            <React.Fragment>
                {this.renderNoFeedUrlsFoundErrorMessage()}

                {this.renderDiscoveredFeedUrls()}
            </React.Fragment>
        );
    }
}

export default FeedDiscoverer;
