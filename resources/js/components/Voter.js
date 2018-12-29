import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import PropTypes from 'prop-types';
import 'whatwg-fetch';
import fetchPut from '../core/request/fetchPut';
import classNames from 'classnames';
import * as Logger from 'js-simple-logger';

const logger = Logger.getLogger();

class Voter extends Component {
    propTyes = {
        voteUpUrl: PropTypes.string.isRequired,
        voteDownUrl: PropTypes.string.isRequired,
        token: PropTypes.string.isRequired,
        voteStatus: PropTypes.string.isRequired,
    };

    state = {
        voteStatus: 'NONE',
    };

    componentDidMount() {
        this.setState((prevState, props) => {
            return {voteStatus: this.props.voteStatus};
        })
    }

    voteUp = () => {
        this.vote(this.props.voteUpUrl);
    };

    voteDown = () => {
        this.vote(this.props.voteDownUrl);
    };

    vote = (url) => {
        return fetchPut(url, this.props.token)
            .then((response) => response.json())
            .then((data) => {
                this.setState((prevState, props) => {
                    return Object.assign({}, {voteStatus: data.vote_status});
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
                <button type="button" className={upBtnClass} onClick={this.voteUp}>
                    <i className="fas fa-chevron-up"></i>
                </button>

                &nbsp;

                <button type="button" className={downBtnClass} onClick={this.voteDown}>
                    <i className="fas fa-chevron-down"></i>
                </button>
            </React.Fragment>
        );
    }
}

export default Voter;