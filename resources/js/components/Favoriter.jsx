import React, {Component} from 'react';
import PropTypes from 'prop-types';
import 'whatwg-fetch';
import classNames from 'classnames';
import * as Logger from 'js-simple-logger';
import LoadingButton from "./LoadingButton";
import {isEmpty} from 'lodash';
import {put} from '../core/request/request';

const logger = Logger.getLogger();

class Favoriter extends Component {
    static propTyes = {
        url: PropTypes.string.isRequired,
        token: PropTypes.string.isRequired,
        favoritedAt: PropTypes.date,
    };

    state = {
        favoritedAt: null,
        buttonIsLoading: false,
    };

    componentDidMount() {
        this.setState((prevState, props) => {
            return {favoritedAt: this.props.favoritedAt};
        })
    }

    handleClickFavorite = () => {
        this.setState((prevState, props) => {
            return Object.assign({}, prevState, {buttonIsLoading: true});
        }, () => {
            put(this.props.url)
                .then((response) => {
                    this.setState((prevState, props) => {
                        return Object.assign({}, prevState, {favoritedAt: response.data.favorited_at, buttonIsLoading: false});
                    });
                });
        });
    };

    render() {
        const btnClass = classNames('btn btn-xs', {
            'btn-outline-dark': isEmpty(this.state.favoritedAt),
            'btn-primary': !isEmpty(this.state.favoritedAt),
        });

        return (
            <React.Fragment>
                <LoadingButton isLoading={this.state.buttonIsLoading} className={btnClass} onClick={this.handleClickFavorite}>
                    <i className="fas fa-star"/>
                </LoadingButton>
            </React.Fragment>
        );
    }
}

export default Favoriter;
