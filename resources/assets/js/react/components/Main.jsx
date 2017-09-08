import {Route, Switch} from 'react-router-dom'
import Feed from "../controllers/Feed";
import React from "react";
import NotFound from "../controllers/NotFound";
import Login from "../controllers/Login";

export const Main = () => (
    <Switch>
        <Route exact path='/' component={Login}/>
        <Route exact path='/feed' component={Feed}/>
        <Route component={NotFound}/>
    </Switch>
);