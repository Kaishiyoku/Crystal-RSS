import React, {Component} from 'react';
import PropTypes from 'prop-types';
import 'whatwg-fetch';
import fetchPut from '../core/request/fetchPut';
import classNames from 'classnames';
import * as Logger from 'js-simple-logger';
import LoadingButton from "./LoadingButton";

const logger = Logger.getLogger();

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
            return fetchPut(url, this.props.token)
                .then((response) => response.json())
                .then((data) => {
                    this.setState((prevState, props) => {
                        return Object.assign({}, {voteStatus: data.vote_status, [field]: false});
                    });
                });
        });
    };

    render() {
        const upBtnClass = classNames('btn btn-xs', {
            'btn-outline-dark': ['NONE', 'DOWN'].includes(this.state.voteStatus),
            'btn-success': this.state.voteStatus === 'UP',
        });

        const downBtnClass = classNames('btn btn-xs', {
            'btn-outline-dark': ['NONE', 'UP'].includes(this.state.voteStatus),
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