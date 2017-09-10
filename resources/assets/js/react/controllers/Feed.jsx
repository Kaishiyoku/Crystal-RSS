import React from "react";
import {get, put} from '../base/request';

class Feed extends React.Component {
    constructor() {
        super();

        this.state = {
            nextOffset: 0,
            totalNumberOfItems: null,
            hasAnotherPage: false,
            feedItems: []
        };
    }

    componentDidMount() {
        get('/api/feed/unread', [], (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    totalNumberOfItems: response.data.totalNumberOfItems,
                    hasAnotherPage: response.data.hasAnotherPage,
                    nextOffset: response.data.nextOffset,
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
                       obj.is_read = response.data.isRead;
                   }

                   return obj;
               })})
            });
        }, (error) => {
            // TODO: handle error
        });
    };

    loadMore = (event) => {
        get('/api/feed/more_unread', [this.state.nextOffset], (response) => {
            this.setState((prevState, props) => {
               return Object.assign(prevState, {
                   hasAnotherPage: response.data.hasAnotherPage,
                   nextOffset: response.data.nextOffset,
                   feedItems: prevState.feedItems.concat(response.data.items)
               });
            });
        }, (error) => {
            // TODO: handle error
        });
    };

    renderOptions() {

    }

    render() {
        let loadMoreButton = this.state.hasAnotherPage ? (
            <p className="mt-3">
                <button type="button" className="btn btn-primary" onClick={this.loadMore}>
                    Load more
                </button>
            </p>
        ) : '';

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
                    {_.isNull(this.state.totalNumberOfItems) ? '' : <small className="text-muted">{this.state.totalNumberOfItems}</small>}
                </h1>

                <ul className="list-group">
                    {feedItems}
                </ul>

                {loadMoreButton}
            </div>
        );
    }
}

export default Feed;