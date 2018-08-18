import React from "react";
import trans from "../base/translate";

class LoadingAnimation extends React.Component {
    render() {
        let visibilityClass = this.props.isVisible ? 'show' : '';

        return (
            <div className={`loading-container ${visibilityClass}`}>
                <div className="spinner">
                    <i className="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                    <span className="sr-only">{trans('common.loading')}</span>
                </div>
            </div>
        );
    }
}

export default LoadingAnimation;