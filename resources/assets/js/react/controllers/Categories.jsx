import React from "react";
import {del, get} from '../base/request';
import trans from "../base/translate";
import {Link} from "react-router-dom";
import Logger from 'js-logger';

class Categories extends React.Component {
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
        get('/api/categories', (response) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {
                    items: response.data
                });
            })
        }, (error) => {
            // TODO: handle error
        });
    }

    addItem = (event) => {
        this.props.history.push('/categories/create');
    };

    deleteItem = (id) => (event) => {
        let isConfirmed = confirm(trans('common.areYouSure'));

        if (isConfirmed) {
            del('/api/categories', (response) => {
                this.loadData();
            }, (error) => {
                // TODO: handle error
            }, [id]);
        }
    };

    getRenderOptions() {
        let categories = this.state.items.map((category) => {
            return (
                <tr key={`category-${category.id}`}>
                    <td>{category.title}</td>
                    <td>{category.feeds_count}</td>
                    <td>
                        <button className="btn btn-link btn-delete" onClick={this.deleteItem(category.id)}>{trans('common.delete')}</button>
                    </td>
                    <td>
                        <Link to={`/categories/edit/${category.id}`}>{trans('common.edit')}</Link>
                    </td>
                </tr>
            );
        });

        let categoriesTable = this.state.items.length > 0 ? (
            <table className="table table-striped">
                <thead>
                <tr>
                    <th>{trans('attributes.title')}</th>
                    <th>{trans('categories.numberOfFeeds')}</th>
                    <th/>
                    <th/>
                </tr>
                </thead>
                <tbody>
                {categories}
                </tbody>
            </table>
        ) : <p className="lead font-italic">{trans('categories.noCategoriesYet')}</p>;

        return {categoriesTable};
    }

    render() {
        let {categoriesTable} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('categories.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <p>
                    <button type="button" className="btn btn-primary" onClick={this.addItem}>{trans('categories.addCategory')}</button>
                </p>

                {categoriesTable}
            </div>
        );
    }
}

export default Categories;