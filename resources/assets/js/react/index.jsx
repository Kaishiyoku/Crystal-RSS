import React from "react";
import ReactDOM from 'react-dom';
import App from "./App";
import {HashRouter} from "react-router-dom";
import $user from "./base/stores/$user";

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

let locale = navigator.language || navigator.userLanguage;

$user.next({locale});