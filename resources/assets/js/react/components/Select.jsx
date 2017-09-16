import Formsy from 'formsy-react';
import React from "react";
import _ from 'lodash';

const Select = React.createClass({
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
        const options = this.props.options.map((option) => {
           return <option value={option.value} key={option.value}>{option.label}</option>
        });

        return (
            <div className="form-group row">
                <label htmlFor={this.props.name} className={`col-form-label ${this.props.labelColClass}`}>{this.props.label}</label>
                <div className={this.props.inputColClass}>
                    <select
                        name={this.props.name}
                        id={this.props.name}
                        onChange={this.changeValue}
                        value={this.getValue()}
                        className={`form-control ${className}`}
                    >
                        {options}
                    </select>
                    <span className="invalid-feedback">{errorMessage}</span>
                </div>
            </div>
        );
    }
});

export default Select;