import React from "react";
import {del, get} from '../base/request';
import trans from "../base/translate";
import {Link} from "react-router-dom";
import notifications$ from "../base/stores/notifications$";
import {Button, DataTable, TableBody, TableColumn, TableHeader, TableRow} from "react-md";

class FeedManager extends React.Component {
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
        get('/api/feed/manage', (response) => {
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
        this.props.history.push('/feed/manage/create');
    };

    deleteItem = (id) => (event) => {
        let isConfirmed = confirm(trans('common.areYouSure'));

        if (isConfirmed) {
            del('/api/feed/manage', (response) => {
                notifications$.next({type: 'success', text: trans('feedManagerDelete.success')});

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
        let feeds = this.state.items.map((feed) => {
            return (
                <TableRow key={`feed-${feed.id}`}>
                    <TableColumn>{feed.title}</TableColumn>
                    <TableColumn>{feed.category.title}</TableColumn>
                    <TableColumn>{feed.last_checked_at}</TableColumn>
                    <TableColumn>
                        <Button flat onClick={this.deleteItem(feed.id)}>{trans('common.delete')}</Button>
                    </TableColumn>
                    <TableColumn>
                        <Button flat onClick={this.routeTo(`/feed/manage/edit/${feed.id}`)}>{trans('common.edit')}</Button>
                    </TableColumn>
                </TableRow>
            );
        });

        let feedTable = this.state.items.length > 0 ? (
            <DataTable plain>
                <TableHeader>
                    <TableRow>
                        <TableColumn>{trans('attributes.title')}</TableColumn>
                        <TableColumn>{trans('attributes.category')}</TableColumn>
                        <TableColumn>{trans('attributes.lastCheckedAt')}</TableColumn>
                        <TableColumn/>
                        <TableColumn/>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {feeds}
                </TableBody>
            </DataTable>
        ) : <p className="lead font-italic">{trans('feedManager.noFeedsYet')}</p>;

        return {feedTable};
    }

    render() {
        let {feedTable} = this.getRenderOptions();

        return (
            <div>
                <h1>
                    {trans('feedManager.title')}
                    {this.state.items.length === 0 ? '' : <small className="text-muted">&nbsp;{this.state.items.length}</small>}
                </h1>

                <p>
                    <Button flat primary onClick={this.addItem}>{trans('feedManager.addFeed')}</Button>
                </p>

                {feedTable}
            </div>
        );
    }
}

export default FeedManager;