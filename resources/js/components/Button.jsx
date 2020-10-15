import React, {Component} from 'react';

class Button extends Component {
    render() {
        const {children, ...otherProps} = this.props;

        return (
            <button type="button" {...otherProps}>
                {children}
            </button>
        );
    }
}

export default Button;
