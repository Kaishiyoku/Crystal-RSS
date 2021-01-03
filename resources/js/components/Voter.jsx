import React, {Component} from 'react';
import PropTypes from 'prop-types';
import 'whatwg-fetch';
import classNames from 'classnames';
import LoadingButton from "./LoadingButton";
import {put} from '../core/request/request';

class Voter extends Component {
    static propTyes = {
        voteUpUrl: PropTypes.string.isRequired,
        voteDownUrl: PropTypes.string.isRequired,
        token: PropTypes.string.isRequired,
        voteStatus: PropTypes.string.isRequired,
    };

    state = {
        voteStatus: 'NONE',
        upButtonIsLoading: false,
        downButtonIsLoading: false,
    };

    componentDidMount() {
        this.setState((prevState, props) => {
            return {voteStatus: this.props.voteStatus};
        })
    }

    voteUp = () => {
        this.vote('upButtonIsLoading', this.props.voteUpUrl);
    };

    voteDown = () => {
        this.vote('downButtonIsLoading', this.props.voteDownUrl);
    };

    vote = (field, url) => {
        this.setState((prevState, props) => {
            return Object.assign({}, {[field]: true});
        }, () => {
            return put(url)
                .then((response) => {
                    this.setState((prevState, props) => {
                        return Object.assign({}, {voteStatus: response.data.vote_status, [field]: false});
                    });
                });
        });
    };

    render() {
        const upBtnClass = classNames('btn btn-sm', {
            'btn-primary-dark': ['NONE', 'DOWN'].includes(this.state.voteStatus),
            'btn-success': this.state.voteStatus === 'UP',
        });

        const downBtnClass = classNames('btn btn-sm', {
            'btn-primary-dark': ['NONE', 'UP'].includes(this.state.voteStatus),
            'btn-danger': this.state.voteStatus === 'DOWN',
        });

        return (
            <React.Fragment>
                <LoadingButton isLoading={this.state.upButtonIsLoading} className={upBtnClass} onClick={this.voteUp}>
                    <i className="fas fa-chevron-up"/>
                </LoadingButton>

                &nbsp;

                <LoadingButton isLoading={this.state.downButtonIsLoading} className={downBtnClass} onClick={this.voteDown}>
                    <i className="fas fa-chevron-down"/>
                </LoadingButton>
            </React.Fragment>
        );
    }
}

export default Voter;
