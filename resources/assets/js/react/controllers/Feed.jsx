import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";

class Feed extends React.Component {
    constructor() {
        super();

        this.state = {
            items: []
        };
    }

    componentDidMount() {
        this.loadData();
    }

    loadData() {
        get('/api/feed/unread', [], (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    items: response.data.items
                });
            })
        }, (error) => {
            // TODO: handle error
        });
    }

    toggleItemStatus = (id) => (event) => {
        put('/api/feed/toggle_status', {id}, (response) => {
            this.setState((prevState, props) => {
               return Object.assign({prevState, items: prevState.items.map((obj) => {
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

    markAllAsRead = (event) => {
        let isConfirmed = confirm('Are you sure?');

        if (isConfirmed) {
            put('/api/feed/mark_all_as_read', {}, (response) => {
                this.setState((prevState, props) => {
                    return Object.assign(prevState, {items: []});
                });
            }, (error) => {
                // TODO: handle error
            });
        }
    };

    refresh = (event) => {
        this.loadData();
    };

    getRenderOptions() {
        let items = this.state.items.map((obj) => {
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

        let feed = this.state.items.length > 0 ? (
            <ul className="list-group">
                {items}
            </ul>
        ) : <p className="lead font-italic">{trans('feed.noUnreadItems')}</p>;

        let markAllAsReadButton = this.state.items.length > 0 ? (
            <button type="button" className="btn btn-secondary" onClick={this.markAllAsRead}>
                <i className="fa fa-eye" aria-hidden="true"></i>
                &nbsp;{trans('feed.markAllAsRead')}
            </button>
        ) : '';

        return {feed, markAllAsReadButton};
    }

    render() {
        let {feed, markAllAsReadButton} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('feed.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <p>
                    <button type="button" className="btn btn-primary" onClick={this.refresh}>
                        <i className="fa fa-refresh" aria-hidden="true"></i>
                        &nbsp;{trans('feed.refreshCompleteList')}
                    </button>
                    &nbsp;
                    {markAllAsReadButton}
                </p>

                {feed}
            </div>
        );
    }
}

export default Feed;