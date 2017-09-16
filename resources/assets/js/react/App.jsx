import React from "react";
import Header from "./components/Header";
import {isLoggedIn, Main} from "./components/Main";
import Footer from "./components/Footer";
import LoadingAnimation from "./components/LoadingAnimation";
import loading$ from "./base/stores/loading$";
import {withRouter} from 'react-router-dom'
import user$ from "./base/stores/user$";
import {get, put} from "./base/request";

class App extends React.Component {
    constructor() {
        super();

        this.state = {isLoading: false};
    }

    componentDidMount() {
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
    }

    render() {
        return (
            <div>
                <Header/>
                <div className="container">
                    <Main/>
                </div>
                <Footer/>

                <LoadingAnimation isVisible={this.state.isLoading}/>
            </div>
        );
    }
}

export default withRouter(App);