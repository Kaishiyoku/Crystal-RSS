import {Redirect, Route, Switch} from 'react-router-dom'
import Feed from "../controllers/Feed";
import React from "react";
import NotFound from "../controllers/NotFound";
import Login from "../controllers/Login";
import Logout from "../controllers/Logout";
import _ from "lodash";
import FeedIndex from "../controllers/FeedIndex";
import CategoriesIndex from "../controllers/CategoriesIndex";
import Registration from "../controllers/Registration";

export function isLoggedIn() {
    return !_.isEmpty(localStorage.getItem('token'));
}

export class RouteAuth extends React.Component {
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
        let {component, path, name, exact, strict, children} = this.props;
        let routeProps = {
            path,
            component,
            name,
            exact,
            strict
        };

        return !isLoggedIn() ? <Route {...routeProps}>{children}</Route> : <Redirect to="/feed" />;
    }
}

export const Main = () => (
    <Switch>
        <RoutePublic exact path="/" component={Login}/>
        <RoutePublic exact path="/register" component={Registration}/>

        <RouteAuth exact path="/logout" component={Logout}/>
        <RouteAuth path="/feed" component={FeedIndex}/>
        <RouteAuth path="/categories" component={CategoriesIndex}/>

        <Route component={NotFound}/>
    </Switch>
);