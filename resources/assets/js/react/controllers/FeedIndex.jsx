import React from "react";
import {RouteAuth} from "../components/Main";
import {Switch} from "react-router-dom";
import FeedHistory from "./FeedHistory";
import Feed from "./Feed";
import FeedManagerIndex from "./FeedManagerIndex";

class FeedIndex extends React.Component {
    render() {
        return (
            <Switch>
                <RouteAuth exact path={`${this.props.match.url}`} component={Feed}/>
                <RouteAuth exact path={`${this.props.match.url}/history`} component={FeedHistory}/>
                <RouteAuth path={`${this.props.match.url}/manage`} component={FeedManagerIndex}/>
            </Switch>
        );
    }
}

export default FeedIndex;