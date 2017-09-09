import Formsy from 'formsy-react';
import React from "react";
import _ from 'lodash';

const Input = React.createClass({
    mixins: [Formsy.Mixin],

    getDefaultProps: function getDefaultProps() {
        return {
            errorMessages: []
        };
    },

    changeValue(event) {
        this.setValue(event.currentTarget.value);
    },

    render() {
        const className = this.props.errorMessages.length > 0 ? 'is-invalid' : '';
        const errorMessage = this.props.errorMessages.join('');

        return (
            <div className="form-group">
                <label htmlFor={this.props.name}>{this.props.label}</label>
                <input
                    name={this.props.name}
                    id={this.props.name}
                    type={this.props.type || 'text'}
                    onChange={this.changeValue}
                    value={this.getValue()}
                    className={`form-control ${className}`}
                />
                <span className="invalid-feedback">{errorMessage}</span>
            </div>
        );
    }
});

export default Input;