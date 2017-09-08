import React from "react";
import Header from "./components/Header";
import {Main} from "./components/Main";

class App extends React.Component {
    render() {
        return (
            <div>
                <Header/>
                <div className="container">
                    <Main/>
                </div>
            </div>
        );
    }
}

export default App;