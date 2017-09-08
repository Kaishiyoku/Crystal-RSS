import Formsy from 'formsy-react';
import React from "react";

const Input = React.createClass({
    mixins: [Formsy.Mixin],

    changeValue(event) {
        this.setValue(event.currentTarget.value);
    },

    render() {
        const className = this.showRequired() ? 'required' : this.showError() ? 'error' : null;

        const errorMessage = this.getErrorMessage();

        return (
            <div className={className}>
                <input type="text" onChange={this.changeValue} value={this.getValue()}/>
                <span>{errorMessage}</span>
            </div>
        );
    }
});

export default Input;