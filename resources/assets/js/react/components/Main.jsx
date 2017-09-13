import {Redirect, Route, Switch} from 'react-router-dom'
import Feed from "../controllers/Feed";
import React from "react";
import NotFound from "../controllers/NotFound";
import Login from "../controllers/Login";
import Logout from "../controllers/Logout";
import FeedHistory from "../controllers/FeedHistory";
import _ from "lodash";

function isLoggedIn() {
    return !_.isEmpty(localStorage.getItem('token'));
}

class RouteAuth extends React.Component {
    constructor(props) {
        super(props);
    }

    static propTypes = {
        canAccess: React.PropTypes.bool,
        component: React.PropTypes.func,
        path: React.PropTypes.string,
        name: React.PropTypes.string,
        exact: React.PropTypes.bool,
        strict: React.PropTypes.bool
    };

    render() {
        let {component, path, name, exact, strict} = this.props;
        let routeProps = {
            path,
            component,
            name,
            exact,
            strict
        };

        return isLoggedIn() ? <Route {...routeProps} /> : <Redirect to="/" />;
    }
}

class RoutePublic extends React.Component {
    constructor(props) {
        super(props);
    }

    static propTypes = {
        canAccess: React.PropTypes.bool,
        component: React.PropTypes.func,
        path: React.PropTypes.string,
        name: React.PropTypes.string,
        exact: React.PropTypes.bool,
        strict: React.PropTypes.bool
    };

    render() {
        let {component, path, name, exact, strict} = this.props;
        let routeProps = {
            path,
            component,
            name,
            exact,
            strict
        };

        return !isLoggedIn() ? <Route {...routeProps} /> : <Redirect to="/feed" />;
    }
}

export const Main = () => (
    <Switch>
        <RoutePublic exact path="/" component={Login}/>

        <RouteAuth exact path="/logout" component={Logout}/>
        <RouteAuth exact path="/feed" component={Feed}/>
        <RouteAuth exact path="/feed/history" component={FeedHistory}/>

        <Route component={NotFound}/>
    </Switch>
);