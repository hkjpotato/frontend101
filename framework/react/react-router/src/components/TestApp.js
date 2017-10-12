import React from 'react';
import { 
  // BrowserRouter, 
  Route, 
  Switch, 
  Link 
} from 'react-router-dom';



function subscribe (WrappedComponent) {
  return class extends React.Component {
    constructor(props) {
      super(props);
      this.state = {
        projectStatus: 'ready'
      }
      this.onStatusChange = this.onStatusChange.bind(this);
    }
    componentDidMount() {
      // setTimeout(() => {
      //   this.setState({
      //     projectStatus: 'done'
      //   })
      // }, 5000)
    }
    onStatusChange(MasterInputData) {
      console.log('going to submit', MasterInputData)
      this.setState({
        projectStatus: 'run'
      });
      setTimeout(() => {
        this.setState({
          projectStatus: 'done'
        })
      }, 5000);
    }
    render() {
      console.log(this.props);
      return (
        <WrappedComponent {...this.state} {...this.props} onStatusChange={this.onStatusChange} />
      );
    }
  }
}



class App extends React.Component {
  constructor(props) {
    super(props);
    /*
    props includes:
    1. projectStatus
    2. onStatusChange
    */
  }
  render() {
    const {
      projectStatus,
      onStatusChange
    } = this.props;
    return (
      <div>
        <Header projectStatus={projectStatus} onStatusChange={onStatusChange} />
        <Main projectStatus={projectStatus} />
      </div>
    )
  }
}


class Header extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      MasterInputData: {
        'hkj': 'king'
      }
    }
    this.onRunClick = this.onRunClick.bind(this);
  }
  componentDidMount() {

  }
  onRunClick() {
    const { MasterInputData } = this.state;
    this.props.onStatusChange(MasterInputData);
  }
  render() {
    const {
      projectStatus,
      onStatusChange
    } = this.props;
    return (
      <div>
        Project Level {projectStatus}
        <Link to="/">Root</Link>
        {' '}
        <Link to="/feeder/feeder1">Feeder1</Link>
        {' '}
        <Link to="/feeder/feeder2">Feeder2</Link>
        <button onClick={this.onRunClick}>Run</button>
      </div>
    )
  }
}

const Main = (props) => (
  <main>
    <Routes {...props} />
  </main>
)

const Routes = (props) => {
  return (
    <Switch>
      <Route exact path='/' component={ProjectRoot} />
      <Route path='/feeder' render={(routerProps) => <Feeder {...routerProps} {...props} />} />
    </Switch>
  );
}

class ProjectRoot extends React.Component {
  constructor(props) {
    super(props);

  }
  render() {
    console.log('ProjectRoot', this.props);
    return <div>ProjectRoot</div>
  }
}

class Feeder extends React.Component {
  constructor(props) {
    super(props);
  }
  render() {
    const { match } = this.props;
    return (
      <div>
        <Route path={`${match.url}/:feederName`} component={FeederItem} />
        <Route path={`${match.url}`} exact render={() => (<div>Feeder Root</div>)} />
      </div>
    );
  }
}


const FeederItem = ({ match }) => (
  <div>{match.params.feederName} item</div>
)
const StatefulApp = subscribe(App);


class MyApp extends React.Component {
  render() {
    return (
      <div>
        <div>head</div>
        <div>
          <Route path="/" exact component={MyRoot} />
          <Route path="/feeder" exact component={MyFeeder} />
        </div>
      </div>
    )
  }
}
// const MyRoot = (props) => {
//   return (<div>My Root</div>)
// }
// const MyFeeder = (props) => {
//   return (
//     <div>
//       My Feeder
//       <Route path="/feeder" exact render={() => <div>Feeder Root</div>} />

//     </div>
//   )
// }



export default StatefulApp;
