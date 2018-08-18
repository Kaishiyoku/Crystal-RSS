import React from "react";
import {Link} from "react-router-dom";
import trans from "../base/translate";

class NotFound extends React.Component {
    render() {
        return (
            <div>
                <h1>{trans('errorPages.404.title')}</h1>

                <h2>{trans('errorPages.404.subTitle')}</h2>

                <p className="pt-5">
                    <Link to="/" className="btn btn-primary btn-lg waves-effect waves-light">{trans('common.backToLandingPage')}</Link>
                </p>
            </div>
        );
    }
}

export default NotFound;