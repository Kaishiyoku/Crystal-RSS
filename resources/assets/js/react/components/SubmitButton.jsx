import React from "react";
import {Link} from "react-router-dom";

class SubmitButton extends React.Component {
    render() {
        return (
            <div className="form-group row">
                <div className={`ml-md-auto ${this.props.colClass}`}>
                    <button className="btn btn-primary" type="submit" disabled={this.props.disabled}>{this.props.label}</button>
                </div>
            </div>
        );
    }
}

export default SubmitButton;