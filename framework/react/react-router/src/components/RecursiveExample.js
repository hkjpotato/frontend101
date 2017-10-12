import React from 'react';
import {
  BrowserRouter,
  Route,
  Link
} from 'react-router-dom';

const NODES = [
  {id: 0, name: 'Node0', neighbours: [1, 2, 3]},
  {id: 1, name: 'Node1', neighbours: [0, 3]},
  {id: 2, name: 'Node2', neighbours: [0, 1, 3]},
  {id: 3, name: 'Node3', neighbours: [1, 2]},
];

const find = (id) => NODES.find(n => n.id == id);

// //pass match object directly, interesting, this will be used as default
const RecursiveExample = () => (
  <BrowserRouter>
    <Node match={{params: {id: 0}, url: ''}} />
  </BrowserRouter>
);

const Node = ({ match }) => {
  console.log(match);
  const node = find(match.params.id);
  return (
    <div>
      <h3>{node.name} neighbours</h3>
      <ul>
        {'nav'}
        {node.neighbours.map(id => (
          <li key={id}>
            <Link to={`${match.url}/${id}`}>
              {find(id).name}
            </Link>
          </li>
        ))}
      </ul>
      <Route path={`${match.url}/:id`} component={Node} />
    </div>
  )
}

export default RecursiveExample;