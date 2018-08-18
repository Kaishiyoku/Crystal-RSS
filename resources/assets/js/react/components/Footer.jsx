import React from "react";
import {NavLink} from "react-router-dom";

class Footer extends React.Component {
    render() {
        let currentYear = (new Date()).getFullYear();
        let startYear = 2017;
        let yearRange = startYear;

        if (currentYear > startYear) {
            yearRange = `${startYear} - ${currentYear}`;
        }

        console.debug(process.env);

        return (
            <div className="container">
                <footer className="z-p-t-50 z-p-b-20">
                    <div className="text-muted">
                        &copy;
                        &nbsp;
                        {yearRange},
                        &nbsp;
                        {process.env.MIX_AUTHOR}
                    </div>
                </footer>
            </div>
        );
    }
}

export default Footer;