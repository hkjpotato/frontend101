var React = require('react');
var Router = require('react-router');
var FeederNav = require('./Feeder/FeederNav');
var FeederProfile = require('./Feeder/FeederProfile');
var Table = require('./Display/Table');


var Feeder = React.createClass({
    getInitialState: function() {
        return {
            selections: [],
            bio: {
                modelName: '12 model'
            },
            data: []
        }
    },
    componentDidMount: function() {
        console.log("hi ni ma bi", this.state);
        this.props.params.feedername
        d3.json('/feeder/graphData/?name=' + this.props.params.feedername, function(data) {
            console.log(data);
        });
    },
    render: function() {
        console.log('Feeder\'s props', this.props);
        // <DisplayNodes childNodes={this.state.nodes} />

        return (
            <div className="row">
                <div className="col-md-4">
                    <FeederProfile feedername={this.props.params.feedername} bio={this.state.bio}/>
                </div> 
                <div className="col-md-4">
                    <FeederNav feedername={this.props.params.feedername} selections={this.state.selections}/>
                </div>
                <div className="col-md-4">
                    <Table feedername={this.props.params.feedername} data={this.state.data}/>
                </div>
            </div>
        )
    }
});

module.exports = Feeder;
