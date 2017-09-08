import React from "react";
import ReactDOM from 'react-dom';
import App from "./App";
import {BrowserRouter} from "react-router-dom";

const rootEl = document.getElementById('app');

ReactDOM.render(
    <BrowserRouter>
        <App/>
    </BrowserRouter>,
    rootEl
);

const render = (Component) => {
    ReactDOM.render(
        <BrowserRouter>
            <Component/>
        </BrowserRouter>,
        rootEl
    );
};

render(App);

if (process.env.NODE_ENV === 'development' && module.hot) {
    module.hot.accept('./App', () => {
        render(App)
    });
}