/*
the Store
1. hold the single application state here
2. allow access to state via getState
3. allow state being updated via dispatch
4. register state change listener via subscribe(listener)
5. unregister via function returned by subscribe


For a Redux application, it is important to have a SINGLE store and thus a SINGLE state tree
instead of having multiple store, use reducer composition!

*/


import { createStore } from 'redux';


import todoApp from './reducers';

let store = createStore(todoApp);

/*
initialState can be specify when creating store (the second argument)
THIS IS NOT the default init state defined in the reducer, this is for store

=>let store = createStore(todoApp, window.STATE_FROM_SERVER)

so yes the state can be stored in server
*/



