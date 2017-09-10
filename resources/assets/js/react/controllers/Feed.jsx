import React from "react";
import {get, put} from '../base/request';

class Feed extends React.Component {
    constructor() {
        super();

        this.state = {
            totalNumberOfItems: 0,
            feedItems: []
        };
    }

    componentDidMount() {
        get('/api/feed/unread', {}, (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    totalNumberOfItems: response.data.totalNumberOfItems,
                    feedItems: response.data.items
                });
            })
        }, (error) => {
            // TODO: handle error
        });
    }

    toggleItemStatus = (id) => (event) => {
        put('/api/feed/toggle_status', {id}, (response) => {
            this.setState((prevState, props) => {
               return Object.assign({prevState, feedItems: prevState.feedItems.map((obj) => {
                   if (obj.id === id) {
                       obj.is_read = response.data.is_read;
                   }

                   return obj;
               })})
            });
        }, (error) => {
            // TODO: handle error
        });
    };

    render() {
        let feedItems = this.state.feedItems.map((obj) => {
            let lowOpacityClass = obj.is_read ? 'low-opacity' : '';
            let eyeClass = obj.is_read ? 'fa-eye-slash' : 'fa-eye';

            return (
                <li className={`list-group-item font-weight-bold ${lowOpacityClass}`} key={`feed-item-${obj.id}`}>
                    <div className="row">
                        <div className="col-lg-1 col-2">
                            <button className="btn btn-outline-primary btn-sm" type="button" onClick={this.toggleItemStatus(obj.id)}>
                                <i className={`fa ${eyeClass}`} aria-hidden="true"></i>
                            </button>
                        </div>
                        <div className="col-lg-8 col-10">
                            <div><a href={obj.url}>{obj.title}</a></div>

                            <div className="row">
                                <div className="col-6 col-lg-12 small">
                                    {obj.feed.title}
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
                <h1>
                    Feed
                    <small className="text-muted">{this.state.totalNumberOfItems}</small>
                </h1>

                <ul className="list-group">
                    {feedItems}
                </ul>
            </div>
        );
    }
}

export default Feed;