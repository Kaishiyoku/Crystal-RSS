import React from "react";
import {get, put} from '../base/request';
import trans from "../base/translate";
import ReactPaginate from 'react-paginate';
import APP_CONFIG from "../app-config";

class FeedManager extends React.Component {
    constructor() {
        super();

        this.state = {
            items: []
        };
    }

    componentDidMount() {

    }

    getRenderOptions() {
        return {};
    }

    render() {
        let {} = this.getRenderOptions();

        return (
            <div>
                <h1>{trans('feedManager.title')}</h1>
            </div>
        );
    }
}

export default FeedManager;