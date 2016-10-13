var React = require('react');

var FeederProfile = React.createClass({
    render: function() {
        return (
            <div>
                <p>Feeder Profile</p>
                <p>Feeder Name: {this.props.feedername}</p>
                <p>Bio: {this.props.bio.modelName}</p>
            </div>
        )
    }
});

module.exports = FeederProfile;