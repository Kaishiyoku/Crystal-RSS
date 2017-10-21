import React from "react";
import {Link} from "react-router-dom";
import {Button} from "react-md";

class SubmitButton extends React.Component {
    render() {
        return (
            <div className="form-group row">
                <div className={`ml-md-auto ${this.props.colClass}`}>
                    <Button raised primary type="submit" disabled={this.props.disabled}>{this.props.label}</Button>
                </div>
            </div>
        );
    }
}

export default SubmitButton;