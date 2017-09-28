import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import ReactPaginate from 'react-paginate';
import APP_CONFIG from "../app-config";
import notifications$ from "../base/stores/notifications$";
import Input from "../components/Input";
import SubmitButton from "../components/SubmitButton";

class Search extends React.Component {
    constructor() {
        super();

        this.state = {
            items: [],
            activePage: 1,
            canSubmit: false,
            searchTerm: '',
            errorMessages: {
                searchTerm: []
            }
        };
    }

    enableButton = () => {
        this.setState({
            canSubmit: true
        });
    };

    disableButton = () => {
        this.setState({
            canSubmit: false
        });
    };

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

    submit = (model) => {
        get('/api/feed/search', (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    activePage: 1,
                    items: response.data
                });
            })
        }, (error) => {
            // TODO: handle error
        }, [model.searchTerm]);
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
        ) : <p className="lead font-italic">{trans('search.nothingFound')}</p>;

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
                    {trans('search.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <Formsy.Form onValidSubmit={this.submit} onValid={this.enableButton} onInvalid={this.disableButton}>
                    <Input name="searchTerm" type="text" label={trans('attributes.searchTerm')} labelColClass="col-lg-2" inputColClass="col-lg-5" errorMessages={this.state.errorMessages.searchTerm} value={this.state.searchTerm} required/>
                    <SubmitButton label={trans('search.submit')} colClass="col-lg-10" disabled={!this.state.canSubmit}/>
                </Formsy.Form>

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

export default Search;