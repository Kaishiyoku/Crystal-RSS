import React, {Component} from 'react';
import PropTypes from 'prop-types';
import * as Logger from 'js-simple-logger';
import Button from "./Button";

const logger = Logger.getLogger();

class LoadingButton extends Component {
    static propTypes = {
        isLoading: PropTypes.bool,
    };

    static defaultProps = {
        isLoading: false,
    };

    render() {
        const {isLoading, children, ...otherProps} = this.props;
        const component = isLoading ? (
            <Button className={otherProps.className} disabled>
                <i className="fas fa-spinner fa-spin"/>
            </Button>
        ) : <Button {...otherProps}>{children}</Button>;

        return (
            <React.Fragment>
                {component}
            </React.Fragment>
        );
    }
}

export default LoadingButton;
