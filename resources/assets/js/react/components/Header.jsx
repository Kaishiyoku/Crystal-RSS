import React from "react";

class Header extends React.Component {
    render() {
        return <nav className="navbar navbar-expand-lg navbar-dark bg-primary z-m-b-25">
            <div className="container">
                <a className="navbar-brand" href="https://crystal-rss.rocks">
                    <img src="https://crystal-rss.rocks/img/logo_small.png" height="30" className="d-inline-block align-top mr-1"/>
                    Crystal RSS
                </a>
                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button>

                <div className="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul className="navbar-nav mr-auto">

                    </ul>
                </div>
            </div>
        </nav>;
    }
}

export default Header;