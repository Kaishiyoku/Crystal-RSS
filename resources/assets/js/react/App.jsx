import React from "react";
import Header from "./components/Header";
import {isLoggedIn, Main} from "./components/Main";
import Footer from "./components/Footer";
import LoadingAnimation from "./components/LoadingAnimation";
import loading$ from "./base/stores/loading$";
import {withRouter} from 'react-router-dom'
import user$ from "./base/stores/user$";
import {get, put} from "./base/request";
import notifications$ from "./base/stores/notifications$";
import Logger from "js-logger";
import trans from "./base/translate";
import {Observable} from "rxjs";
import {formatTime} from "./base/formatters/dateFormatter";

const NOTIFICATION_DURATION = 15000;

class App extends React.Component {
    constructor() {
        super();

        this.state = {
            isLoading: false,
            notifications: []
        };
    }

    componentDidMount() {
        // remove oldest notification every x seconds
        Observable.timer(NOTIFICATION_DURATION, NOTIFICATION_DURATION).subscribe((state) => {
            if (this.state.notifications.length > 0) {
                this.setState((prevState, props) => {
                    let notifications = prevState.notifications;
                    notifications.pop();

                    Logger.debug('Removed oldest notification');

                    return Object.assign(prevState, {notifications});
                });
            }
        });

        this.loadingSubscription = loading$.subscribe((isLoading) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {isLoading});
            });
        });

        this.userSubscription = user$.subscribe((state) => {
            put('/api/store/update', (response) => {

            }, (error) => {
                // TODO: handle error
            }, {user: state})
        });

        this.notificationsSubscriptions = notifications$.subscribe((state) => {
            this.setState((prevState, props) => {
                let notifications = prevState.notifications;
                notifications.unshift(Object.assign({}, state, {time: new Date()}));

                return Object.assign(prevState, {notifications});
            });
        });

        // when logged repopulate stores saved with redis
        if (isLoggedIn()) {
            get('/api/store/retrieve', (response) => {
                user$.next(response.data.user);
            }, (error) => {
                // TODO: handle error
            });
        }
    }

    componentWillUnmount() {
        this.loadingSubscription.unsubscribe();
        this.userSubscription.unsubscribe();
        this.notificationsSubscriptions.unsubscribe();
    }

    removeNotification = (i) => (event) => {
        this.setState((prevState, props) => {
            let notifications = prevState.notifications;
            notifications.pop();

            return Object.assign(prevState, {notifications});
        });
    };

    render() {
        let notifications = this.state.notifications.map((notification, i) => {
            return (
                <div className={`alert alert-${notification.type}`} key={`notification-${i}`}>
                    <button type="button" className="close" data-dismiss="alert" aria-label={trans('common.close')} onClick={this.removeNotification(i)}>
                        <span aria-hidden="true">&times;</span>
                    </button>

                    {formatTime(notification.time)} {notification.text}
                </div>
            );
        });

        return (
            <div>
                <Header/>

                <div className="container">
                    {notifications}

                    <Main/>
                </div>

                <Footer/>

                <LoadingAnimation isVisible={this.state.isLoading}/>
            </div>
        );
    }
}

export default withRouter(App);