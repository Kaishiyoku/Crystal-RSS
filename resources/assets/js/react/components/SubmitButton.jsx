import React from "react";
import {Button} from "material-ui";

class SubmitButton extends React.Component {
    render() {
        return (
            <div className="form-group row">
                <div className={`ml-md-auto ${this.props.colClass}`}>
                    <Button raised color="primary" type="submit" disabled={this.props.disabled}>{this.props.label}</Button>
                </div>
            </div>
        );
    }
}

export default SubmitButton;