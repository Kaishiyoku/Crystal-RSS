import React from "react";
import {Link, NavLink} from "react-router-dom";
import trans from "../base/translate";

class Header extends React.Component {
    render() {
        let isLoggedIn = localStorage.getItem('token');

        let landingPageLink = !isLoggedIn ? <li className="nav-item"><NavLink to="/" className="nav-link"><i className="fa fa-home"></i> {trans('navigation.landingPage')}</NavLink></li> : '';

        let feedLink = isLoggedIn ? <li className="nav-item"><NavLink to="/feed" className="nav-link"><i className="fa fa-rss" aria-hidden="true"></i> {trans('navigation.feed')}</NavLink></li> : '';
        let logoutLink = isLoggedIn ? <li className="nav-item"><NavLink to="/logout" className="nav-link"><i className="fa fa-sign-out"></i> {trans('navigation.logout')}</NavLink></li> : '';

        return <nav className="navbar navbar-expand-lg navbar-dark bg-primary z-m-b-25">
            <div className="container">
                <Link to="/" className="navbar-brand">
                    <img src="https://crystal-rss.rocks/img/logo_small.png" height="30" className="d-inline-block align-top mr-1"/>
                    {trans('common.appName')}
                </Link>

                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav mr-auto">
                        {landingPageLink}
                        {feedLink}
                    </ul>

                    <ul className="navbar-nav">
                        {logoutLink}
                    </ul>
                </div>
            </div>
        </nav>;
    }
}

export default Header;