import React from "react";
import {RouteAuth} from "../components/Main";
import {Switch} from "react-router-dom";
import FeedHistory from "./FeedHistory";
import Feed from "./Feed";
import FeedManagerIndex from "./FeedManagerIndex";
import Categories from "./Categories";
import CategoriesCreate from "./CategoriesCreate";

class CategoriesIndex extends React.Component {
    render() {
        return (
            <Switch>
                <RouteAuth exact path={`${this.props.match.url}`} component={Categories}/>
                <RouteAuth exact path={`${this.props.match.url}/create`} component={CategoriesCreate}/>
            </Switch>
        );
    }
}

export default CategoriesIndex;