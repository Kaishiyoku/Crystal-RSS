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

        return (
            <div className="container">
                <footer className="z-p-t-50 z-p-b-20">
                    <div className="text-muted">
                        {yearRange},

                        Andreas Wiedel
                    </div>
                </footer>
            </div>
        );
    }
}

export default Footer;