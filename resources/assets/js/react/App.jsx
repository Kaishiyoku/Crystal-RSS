import React from "react";
import Header from "./components/Header";
import {Main} from "./components/Main";
import Footer from "./components/Footer";

class App extends React.Component {
    render() {
        return (
            <div>
                <Header/>
                <div className="container">
                    <Main/>
                </div>
                <Footer/>
            </div>
        );
    }
}

export default App;