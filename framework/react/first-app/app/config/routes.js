var React = require('react');
var Main = require('../components/Main');
var Home = require('../components/Home');
var Feeder = require('../components/Feeder');
var Router = require('react-router');
var Route = Router.Route;
var IndexRoute = Router.IndexRoute;


module.exports = (
    <Route path="/" component={Main}>
        <Route path="feeder/:feedername" component={Feeder} />
        <IndexRoute component={Home} />
    </Route>
)
