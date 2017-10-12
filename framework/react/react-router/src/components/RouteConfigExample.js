import React from 'react';
import {
  BrowserRouter,
  Route,
  Link
} from 'react-router-dom';


const RouteConfigExample = () => (
  <BrowserRouter>
    <div>
      <ul>
        <li><Link to="/tacos">Tacos</Link></li>
        <li><Link to="/sandwiches">Sandwiches</Link></li>
      </ul>
      
    </div>
  </BrowserRouter>
);


////////////////////////////////////////////////////////////
//route configs, is an array here, use to map different Route
const routes = [
  {
    path: '/sandwiches',
    component: Sandwiches
  },
  {
    path: '/tacos',
    component: Tacos,
    routes: [
      {
        path: '/tacos/bus',
        component: Bus
      },
      {
        path: '/tacos/cart',
        component: Cart
      }
    ]
  }
]


