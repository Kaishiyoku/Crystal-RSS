import React from "react";
import {del, get} from '../base/request';
import trans from "../base/translate";
import {Link} from "react-router-dom";
import notifications$ from "../base/stores/notifications$";
import {Button} from "material-ui";

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

    getRenderOptions() {
        let feeds = this.state.items.map((feed) => {
            return (
                <tr key={`feed-${feed.id}`}>
                    <td>{feed.title}</td>
                    <td>{feed.category.title}</td>
                    <td>{feed.last_checked_at}</td>
                    <td>
                        <Button onClick={this.deleteItem(feed.id)}>{trans('common.delete')}</Button>
                    </td>
                    <td>
                        <Button onClick={() => this.props.history.push(`/feed/manage/edit/${feed.id}`)}>
                            {trans('common.edit')}
                        </Button>
                    </td>
                </tr>
            );
        });

        let feedTable = this.state.items.length > 0 ? (
          <table className="table table-striped">
              <thead>
              <tr>
                  <th>{trans('attributes.title')}</th>
                  <th>{trans('attributes.category')}</th>
                  <th>{trans('attributes.lastCheckedAt')}</th>
                  <th/>
                  <th/>
              </tr>
              </thead>
              <tbody>
              {feeds}
              </tbody>
          </table>
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
                    <Button color="primary" onClick={this.addItem}>{trans('feedManager.addFeed')}</Button>
                </p>

                {feedTable}
            </div>
        );
    }
}

export default FeedManager;