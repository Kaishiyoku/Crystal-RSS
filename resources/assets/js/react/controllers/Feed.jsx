import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import ReactPaginate from 'react-paginate';
import APP_CONFIG from "../app-config";

class Feed extends React.Component {
    constructor() {
        super();

        this.state = {
            items: [],
            activePage: 1
        };
    }

    componentDidMount() {
        this.loadData();
    }

    loadData() {
        get('/api/feed/unread', (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    items: response.data
                });
            })
        }, (error) => {
            // TODO: handle error
        });
    }

    toggleItemStatus = (id) => (event) => {
        put('/api/feed/toggle_status', (response) => {
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
        }, {id});
    };

    markAllAsRead = (event) => {
        let isConfirmed = confirm(trans('common.areYouSure'));

        if (isConfirmed) {
            put('/api/feed/mark_all_as_read', (response) => {
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

    handlePageChange = (event) => {
        this.setState((prevState, props) => {
            return Object.assign(prevState, {activePage: event.selected + 1});
        })
    };

    getRenderOptions() {
        let itemStart = (this.state.activePage - 1) * APP_CONFIG.pagination.itemsPerPage;
        let itemEnd = itemStart + APP_CONFIG.pagination.itemsPerPage;

        let items = this.state.items.slice(itemStart, itemEnd).map((obj) => {
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

        let pageCount = this.state.items.length / APP_CONFIG.pagination.itemsPerPage;

        let pagination = pageCount > 0 ? (
            <ReactPaginate
                previousClassName="page-item"
                previousLinkClassName="page-link"
                previousLabel="«"
                nextClassName="page-item"
                nextLinkClassName="page-link"
                nextLabel="»"
                breakLabel="..."
                breakClassName={"page-break-item"}
                forcePage={this.state.activePage - 1}
                pageCount={pageCount}
                marginPagesDisplayed={APP_CONFIG.pagination.marginPagesDisplayed}
                pageRangeDisplayed={APP_CONFIG.pagination.pageRangeDisplayed}
                onPageChange={this.handlePageChange}
                containerClassName={"pagination"}
                pageClassName="page-item"
                pageLinkClassName="page-link"
                activeClassName={"active"}
            />
        ) : '';

        return {feed, markAllAsReadButton, pagination};
    }

    render() {
        let {feed, markAllAsReadButton, pagination} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('feed.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <p className="pb-4">
                    <button type="button" className="btn btn-primary" onClick={this.refresh}>
                        <i className="fa fa-refresh" aria-hidden="true"></i>
                        &nbsp;{trans('feed.refreshCompleteList')}
                    </button>
                    &nbsp;
                    {markAllAsReadButton}
                </p>

                <div className="mb-4">
                    {pagination}
                </div>

                {feed}

                <div className="mt-4">
                    {pagination}
                </div>
            </div>
        );
    }
}

export default Feed;