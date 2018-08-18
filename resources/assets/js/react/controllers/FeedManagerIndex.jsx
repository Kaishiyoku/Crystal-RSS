import React from "react";
import {Switch} from "react-router-dom";
import {RouteAuth} from "../components/Main";
import FeedManager from "./FeedManager";
import FeedManagerCreate from "./FeedManagerCreate";
import FeedManagerEdit from "./FeedManagerEdit";

class FeedManagerIndex extends React.Component {
    render() {
        return (
            <div>
                <Switch>
                    <RouteAuth exact path={`${this.props.match.url}`} component={FeedManager}/>
                    <RouteAuth exact path={`${this.props.match.url}/create`} component={FeedManagerCreate}/>
                    <RouteAuth exact path={`${this.props.match.url}/edit/:id`} component={FeedManagerEdit}/>
                </Switch>
            </div>
        );
    }
}

export default FeedManagerIndex;