import {Redirect, Route, Switch} from 'react-router-dom'
import Feed from "../controllers/Feed";
import React from "react";
import NotFound from "../controllers/NotFound";
import Login from "../controllers/Login";
import Logout from "../controllers/Logout";
import _ from "lodash";

function PrivateRoute(Component, ...rest) {
    return (
        <Route
            {...rest}
            render={(props) => !_.isEmpty(localStorage.getItem('token'))
                ? <Component {...props} />
                : <Redirect to={{pathname: '/', state: {from: props.location}}} />}
        />
    )
}

export const Main = () => (
    <Switch>
        <Route exact path="/" component={Login}/>
        <PrivateRoute exact path="/feed" component={Feed}/>
        <Route exact path="/logout" component={Logout}/>
        <Route component={NotFound}/>
    </Switch>
);