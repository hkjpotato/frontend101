import React from 'react';
import ReactDOM from 'react-dom';
import StatefulApp from './components/TestApp';
import RecursiveExample from './components/RecursiveExample';

import { 
  BrowserRouter, 
  Route, 
  Switch, 
  Link 
} from 'react-router-dom';

const App = () => (
  <div>
    <Header />
    <Main />
  </div>
);

const Header = () => (
  <div>
    <nav>
      <ul>
        <li><Link to='/'>Home</Link></li>
        <li><Link to='/render'>by render</Link></li>
        <li><Link to='/nested'>by component (nested)</Link></li>
        <li><Link to='/children'>by children</Link></li>
      </ul>
    </nav>
  </div>
)

const Main = () => (
  <main>
    <Routes />
  </main>
)

const Home = (props) => {
  console.log('/home', props);
  return <div>Home</div>
}


const Nested = (props) => {
  // nested route
  /*
  instead hard code /nested, you can use 
  const {match} = props;
  match.url to determine the root for nested
  path={match.url + /:number} <= relative path
  */
  return (
    <div>
      <h2>This is Nested Route</h2>
      <Route exact path='/nested' component={NestedRoot} />
      <Route path='/nested/:number' component={NestedItem} />
    </div>
  );
}

const NestedRoot = (props) => (
  <div>
    <h3>nested root</h3>
    <p>{"a real link will refresh"} <a href="/nested/1">{"a real link to #1"}</a></p>
    <p>{"a Link component will not refresh"} <Link to={{pathname: '/nested/1'}}>{"a Link to #2"}</Link></p>
  </div>
)

const NestedItem = (props) => {
  console.log(props);
  return (
    <div>{"NestedItem" + props.match.params.number}</div>
  )
}

const Render = (props) => {
  console.log('/render', props);
  return (
    <div>{'Render ' + JSON.stringify(props, null, 4)} </div>
  )
}

/* props for a route
  {
    match : {
      url, // after '/' e.g. /nested/4
      path, // match path, e.g. /nested:number
      isExact, 
      params //{}
    }
  },
  location: {
    // object with properties to describe different parts of a url
    pathName, // the real path, e.g. /nested/4
    search, // query, ?xxx
    hash, // hash, #xxx
    key,
    state,
  },
  history: {
    // reated by router, you need to embed Route inside Router
  }
*/
const Routes = () => {
  const extraProps = { color: 'red' } 
  return (
    <Switch>
      <Route exact path='/' component={Home} />
      <Route path='/nested' component={Nested} />
      <Route path='/render' render={(props)=> {
        // render => props.render() vs component => React.createElement(props.component) 
        // a chance to inject extra props, you can do that with component
        return <Render {...props} extra={extraProps} />
      }} />
      <Route path='/children' children={(props => {
        console.log('/children', props); //eldom used, always render, need to decide match logic here
        return props.match ? <div>match</div> : <div>not match</div>
      })} />
    </Switch>
  );
}
/*
Rout is the main building block:
render something if it matches the location's pathname
*/

// ReactDOM.render((
//   <RecursiveExample />
// ), document.getElementById('root'));

// basename="/projects/hello"
ReactDOM.render((
  <BrowserRouter basename="/projects/hello">
    <StatefulApp />
  </BrowserRouter>
), document.getElementById('root'));