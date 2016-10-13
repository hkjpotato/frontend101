var React = require('react');
var ReactDOM = require('react-dom');
var Main = React.createClass({
  render: function() {
    console.log('so, what it is the children of main now?: ', this.props.children)
    return (
        <div className="main-container">
            <nav id="mainNav" className="navbar navbar-default navbar-custom navbar-fixed-top">
                <div className="container">
                    <div className="navbar-header page-scroll">
                        <button type="button" className="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span className="sr-only">Toggle navigation</span> Menu <i className="fa fa-bars"></i>
                        </button>
                        <a className="navbar-brand page-scroll" href="#page-top">ProsumerGrid</a>
                    </div>
                    <div className="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul className="nav navbar-nav navbar-right">
                            <li className="hidden">
                                <a href="#page-top"></a>
                            </li>
                            <li>
                                <a className="page-scroll" href="#services">What</a>
                            </li>
                            <li>
                                <a className="page-scroll" href="#contact">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div className="container" style={{paddingTop: 65}}>
                {this.props.children}
            </div>
        </div>
    )
  }
});
module.exports = Main;
