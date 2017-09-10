import React from "react";
import Header from "./components/Header";
import {Main} from "./components/Main";
import Footer from "./components/Footer";
import LoadingAnimation from "./components/LoadingAnimation";
import $loading from "./base/stores/$loading";
import $user from "./base/stores/$user";
import {withRouter} from 'react-router-dom'

class App extends React.Component {
    constructor() {
        super();

        this.state = {isLoading: false};
    }

    componentDidMount() {
        this.loadingSubscription = $loading.subscribe((isLoading) => {
            this.setState((prevState, props) => {
                return Object.assign(prevState, {isLoading});
            });
        });
    }

    componentWillUnmount() {
        this.loadingSubscription.unsubscribe();
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