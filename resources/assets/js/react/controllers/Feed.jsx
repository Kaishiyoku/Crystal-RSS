import React from "react";
import axios from 'axios';

class Feed extends React.Component {
    componentDidMount() {
        axios.get('/api/feed/unread', {

        }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    render() {
        return (
            <div>
                <h1>Feed</h1>
            </div>
        );
    }
}

export default Feed;