import React from "react";
import {del, get} from '../base/request';
import trans from "../base/translate";
import notifications$ from "../base/stores/notifications$";
import {Button, DataTable, TableBody, TableColumn, TableHeader, TableRow} from "react-md";

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
                notifications$.next({type: 'success', text: trans('categoriesDelete.success')});

                this.loadData();
            }, (error) => {
                // TODO: handle error
            }, [id]);
        }
    };

    routeTo = (route) => (event) => {
        this.props.history.push(route);
    };

    getRenderOptions() {
        let categories = this.state.items.map((category) => {
            return (
                <TableRow key={`category-${category.id}`}>
                    <TableColumn>{category.title}</TableColumn>
                    <TableColumn>{category.feeds_count}</TableColumn>
                    <TableColumn>
                        <Button flat onClick={this.deleteItem(category.id)}>{trans('common.delete')}</Button>
                    </TableColumn>
                    <TableColumn>
                        <Button flat
                                onClick={this.routeTo(`/categories/edit/${category.id}`)}>{trans('common.edit')}</Button>
                    </TableColumn>
                </TableRow>
            );
        });

        let categoriesTable = this.state.items.length > 0 ? (
            <DataTable plain>
                <TableHeader>
                    <TableRow>
                        <TableColumn>{trans('attributes.title')}</TableColumn>
                        <TableColumn>{trans('categories.numberOfFeeds')}</TableColumn>
                        <TableColumn/>
                        <TableColumn/>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {categories}
                </TableBody>
            </DataTable>
        ) : <p className="lead font-italic">{trans('categories.noCategoriesYet')}</p>;

        return {categoriesTable};
    }

    render() {
        let {categoriesTable} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('categories.title')}
                    {this.state.items.length === 0 ? '' :
                        <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <p>
                    <Button flat primary onClick={this.addItem}>{trans('categories.addCategory')}</Button>
                </p>

                {categoriesTable}
            </div>
        );
    }
}

export default Categories;