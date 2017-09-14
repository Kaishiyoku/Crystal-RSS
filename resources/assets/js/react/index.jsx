import React from "react";
import ReactDOM from 'react-dom';
import App from "./App";
import {HashRouter} from "react-router-dom";
import {setLocale} from "./base/translate";

setLocale(navigator.language || navigator.userLanguage);

const rootEl = document.getElementById('app');

const render = (Component) => {
    ReactDOM.render(
        <HashRouter>
            <Component/>
        </HashRouter>,
        rootEl
    );
};

render(App);

if (process.env.NODE_ENV === 'development' && module.hot) {
    module.hot.accept('./App', () => {
        render(App)
    });
}