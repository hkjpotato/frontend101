var React = require('react');
var Home = React.createClass({
    render: function () {
        console.log('hi home page render props params', this.props.params);
        return (
            <div className="home-div">
                <h2 className="text-center">
                    ProsumerGrid Data Explorator
                </h2>
            </div>
        )
    }
});
module.exports = Home;