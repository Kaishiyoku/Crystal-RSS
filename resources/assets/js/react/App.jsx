import React from "react";
import Header from "./components/Header";
import {Main} from "./components/Main";
import Footer from "./components/Footer";
import LoadingAnimation from "./components/LoadingAnimation";
import $loading from "./base/stores/$loading";

class App extends React.Component {
    constructor() {
        super();

        this.state = {isLoading: false};
    }

    componentDidMount() {
        this.subscription = $loading.subscribe((isLoading) => {
            this.setState({isLoading})
        });
    }

    componentWillUnmount() {
        this.subscription.unsubscribe();
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

export default App;