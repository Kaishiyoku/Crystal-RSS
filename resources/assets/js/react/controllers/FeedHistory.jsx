import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import ReactPaginate from 'react-paginate';
import APP_CONFIG from "../app-config";

class FeedHistory extends React.Component {
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
        get('/api/feed/read', (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    items: response.data
                });
            })
        }, (error) => {
            // TODO: handle error
        });
    }

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
            return (
                <li className="list-group-item font-weight-bold" key={`feed-item-${obj.id}`}>
                    <div className="row">
                        <div className="col-lg-9 col-12">
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
        ) : <p className="lead font-italic">{trans('feedHistory.noReadItems')}</p>;

        let pageCount = this.state.items.length / APP_CONFIG.pagination.itemsPerPage;

        let pagination = pageCount > 1 ? (
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

        return {feed, pagination};
    }

    render() {
        let {feed, pagination} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('feedHistory.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <div className="mt-4 mb-4">
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

export default FeedHistory;