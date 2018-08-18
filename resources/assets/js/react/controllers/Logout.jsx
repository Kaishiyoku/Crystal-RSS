import React from "react";
import {del} from "../base/request";
import notifications$ from "../base/stores/notifications$";
import trans from "../base/translate";

class Logout extends React.Component {
    constructor() {
        super();

        this.state = {};
    }

    componentDidMount() {
        del('/api/store/clear', (response) => {
            let locale = localStorage.getItem('locale');
            localStorage.clear();
            localStorage.setItem('locale', locale);

            notifications$.next({type: 'success', text: trans('logout.success')});

            this.props.history.push('/');
        }, (error) => {
            // TODO: handle error
        });
    }

    render() {
        return (
            <div>
            </div>
        )
    }
}

export default Logout;