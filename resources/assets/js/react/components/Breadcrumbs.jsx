import React from "react";
import {Link} from "react-router-dom";
import _ from 'lodash';

class Breadcrumbs extends React.Component {
    getRenderOptions() {
        let breadcrumbs = this.props.links.map((breadcrumb, i) => {
            let link = _.isEmpty(breadcrumb.to) ? breadcrumb.label : <Link to={breadcrumb.to}>{breadcrumb.label}</Link>;
            let breadcrumbClass =`breadcrumb-item${i === this.props.links.length - 1 ? ' active' : ''}`;

           return (
               <li className={breadcrumbClass} key={`breadcrumb-${i}`}>
                   {link}
               </li>
           );
        });

        return {breadcrumbs};
    }

    render() {
        let {breadcrumbs} = this.getRenderOptions();

        return (
            <ol className="breadcrumb">
                {breadcrumbs}
            </ol>
        );
    }
}

export default Breadcrumbs;