import React from "react";

class Logout extends React.Component {
    constructor() {
        super();

        this.state = {};
    }

    componentDidMount() {
        localStorage.clear();

        this.props.history.push('/');
    }

    render() {
        return (
            <div>
            </div>
        )
    }
}

export default Logout;