import React, {Component} from 'react';
import * as Logger from 'js-simple-logger';

const logger = Logger.getLogger();

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