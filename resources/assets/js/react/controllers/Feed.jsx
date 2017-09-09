import React from "react";
import {get} from '../base/request';

class Feed extends React.Component {
    constructor() {
        super();

        this.state = {feedItems: []};
    }

    loadData = () => {
        get('/api/feed/unread', {}, (response) => {
            this.setState({feedItems: response.data})
        }, (error) => {
            // TODO: handle error
        });
    };

    render() {
        let feedItems = this.state.feedItems.map((obj) => {
            return (
                <li className="list-group-item font-weight-bold" key={`feed-item-${obj.id}`}>
                    <div className="row">
                        <div className="col-lg-1 col-2">
                            <button className="btn btn-outline-primary btn-sm" type="button"><i className="fa fa-eye" aria-hidden="true"></i></button>
                        </div>
                        <div className="col-lg-8 col-10">
                            <div><a href={obj.url}>{obj.title}</a></div>

                            <div className="row">
                                <div className="col-6 col-lg-12 small">
                                    RT Deutsch (TODO)
                                </div>
                                <div className="col-6 d-none-md d-lg-none d-xl-none text-right small font-weight-bold">
                                    {obj.date}
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-3 text-right d-none d-lg-block d-xl-block">
                            {obj.date}
                        </div>
                    </div>
                </li>
            );
        });

        return (
            <div>
                <h1>Feed</h1>

                <button type="button" onClick={this.loadData}>Load data</button>

                <ul className="list-group">
                    {feedItems}
                </ul>
            </div>
        );
    }
}

export default Feed;